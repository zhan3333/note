# FPM

## 概述

FPM(FastCGI Process Manager)是 PHP FastCGI 运行模式的一个进程管理器.

FastCGI 是 Web 服务器和处理程序之间的一种通信协议, 是与 Http 类似的一种`应用层`通信协议.

- cli 模式
- FastCGI 协议模式

PHP 只是一个脚本解析器, 没有自带的 http 网络库.

web 服务器处理 http 请求, 将解析结果通过 FastCGI 协议转发给处理程序,处理程序处理完后将结果返回给 web 服务器,web 服务器再返回给用户.

fpm 的实现: 创建一个 master 进程,在 master 进程中创建并监听 socket,然后 fork 出多个子进程,这些子进程各自 accept 请求,子进程启动后将阻塞在 accept 上,有请求大道后开始读取请求数据,读取完成后开始处理然后返回,在这个期间是不会接收其它请求的

> fpm 的子进程同时只能响应一个请求

nginx 事件驱动有很大区别,nginx 的子进程通过`epoll`管理套接字,一个请求数据还未发送完毕则会处理下一个请求, 即单进程处理多个请求, 非阻塞的模型, 只处理活跃的套接字

fpm 的 master 通过共享内存获取 worker 进程的信息(worker 当前状态,已处理请求),master 进程杀掉 worker 时通过发送信号的方式通知

fpm 可以同时监听多个端口,每个端口对应一个 worker pool, 每个 pool 下对应多个 worker 进程

worker pool 通过`fpm_worker_pool_s`结构表示

## FPM 初始化

1. sapi_startup(&cgi_sapi_module) // 注册 SAPI:将全局变量 sapi_module 设置为 cgi_sapi_module
2. cgi_sapi_module.startup() // 执行 php_module_startup()
3. fpm_init() // 初始化

- fpm_conf_init_main() // 加载 php-fpm.conf 配置
  - fpm_scoreboard_init_main() // 分配用于记录 worker 进程运行信息的共享内存, 按照 worker pool 的最大 worker 进程数分配, 每个 worker pool 分配一个`fpm_scoreboard_s`结构, pool 下对应每个 worker 进程分配一个 `fpm_socreboard_proc_s`结构
  - fpm_signals_init_main() // 创建管道, 只在 master 进程中使用, 用于处理 master 进程接收到不同的信号时, 使用`sig_handler()`来处理
  - fpm_sockets_init_main() // 创建每个 worker pool 的 socket 套接字
  - fpm_event_init_main() // 启动 master 的事件管理,fpm 实现了一个事件管理器用于管理 IO, 定时事件, 其中 IO 事件通过 kqueue,epoll,poll,select 等管理

4. fpm_run() // 启动 worker 进程

## 请求处理

`fpm_run`执行后将 fork 出 worker 进程,worker 进程返回`main()`中继续向下执行,后面的流程就是 worker 进程不断 accept 请求,然后执行 PHP 脚本并返回.

master 进程将永远阻塞在`fpm_event_loop()`, worker 将继续后面的处理

1. 等待请求: worker 进程阻塞在 fcgi_accept_request()等待请求;
2. 解析请求: fastcgi 请求大道后被 worker 接收,然后开始接收并解析请求数据,直到 request 数据完全到达;
3. 请求初始化: 执行 php_request_startup(),此阶段会调用每个扩展的: PHP_RINIT_FUNCTION();
4. 编译,执行: 由 php_execute_script()完成 PHP 脚本的编译,执行;
5. 关闭请求: 请求完成后执行 php_request_shutdown(), 此阶段会调用每个扩展的: PHP_RSHUTDOWN_FUNCTION(), 然后进入步骤 1 继续等待下一个请求;

worker 进程一次请求的处理被划分为 5 阶段:

- FPM_REQUEST_ACCEPTING: 等待请求阶段
- FPM_REQUEST_READING_HEADERS: 读取 fastcgi 请求 header 阶段
- FPM_REQUEST_INFO: 获取请求信息阶段,此阶段是将请求的 methond,query string, request uri 等信息保存到各 worker 进程的 fpm_scoreboard_proc_s 结构中,此操作需要加锁,因为 master 进程也会操作此结构.
- FPM_REQUEST_EXECUTING: 请求执行阶段
- FPM_REQUEST_END: 没有使用
- FPM_REQUEST_FINISHED: 请求完成阶段

worker 的处理阶段会更新到`fpm_scoreboard_proc_s->request_stage`, master 进程通过这个判断 worker 是否空闲的

## 进程管理

> master 是如何管理 worker 进程的

- `static`:固定 worker 数, pm.max_children 配置
- `dynamic`:动态进程管理,包含初始化数量(pm.start_servers),最小空闲数(pm.min_spare_servers),最大空闲数(pm.max_spare_servers),最大数(pm.max_children)
- `ondemand`:启动时不分配 worker,等有请求了再创建 worker 进程,最大不超过 max_children, 空闲时间超过(pm.process_idle_timeout)后退出

> master 进程管理中主要用到的几个事件

### sp[1]管道可读事件

这个事件是 master 用于处理信号的

- SIGINT/SIGTERM/SIGQUIT: 退出 fpm, 在 master 收到退出信号后将向所有的 worker 进程发送退出信号,然后 master 退出
- SIGUSR1: 重新加载日志文件, 生产环境通常会对日志进行切割, 切割后悔生成一个新的日志文件,不重启的话 fpm 无法继续写入日志
- SIGUSR2: 重启 fpm,首先 master 会向所有的 worker 进程发送退出信号,然后 master 会调用 execvp()重新启动 fpm,最后旧的 master 退出
- SIGCHLD, 这个信号时子进程退出时发送给父进程的. 子进程退出时,内核将子进程置为僵尸状态,父进程需要调用 wait 或者 waitpid 函数查询子进程状态,子进程才会终止.

### fpm_pctl_perform_idle_server_maintenance_heartbeat()

进程管理实现的主要事件, master 启动了一个定时器,每隔 1s 触发一次,主要用于 dynamic,ondemand 模式下的 worker 管理

### fpm_pctl_heartbeat()

这个事件是用于限制 worker 处理单个请求最大耗时的,超过`request_terminate_timeout`配置项后,master 将会向此进程发送`kill -TERM`信号杀掉 worker 进程, 默认是关闭的. fpm slow log 也在这里完成
