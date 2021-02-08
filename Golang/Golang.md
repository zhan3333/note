# Golang

## 哪些数据类型是引用

go 中四种引用类型有 slice， channel， function， map

## [2] etcd (如何保证高可用, 选举机制, 脑裂如何解决)

### 是什么

分布式, 可靠的 k-v 储存系统

### 如何保证高可用

通过Raft一致性算法处理日志复制以保证强一致性

### raft 选举

是一种分布式一致性算法

流程: 集群选出一个节点作为 leader , leader 负责接收客户端的请求(日志),并负责把请求复制给所有的从节点, 保证节点之间的数据同步.如果 leader 节点出现故障挂掉,那么其他正常节点会重新选择leader
节点三个状态: leader 领导, follower 从节点, candidate 候选人
任期: 任期是依次递增的编号, 每次选举都是一个新的任期. 主要目的是保证所有节点逻辑时间上的一致,避免过期请求导致逻辑混乱的情况.
避免节点票数都未过半: 随机时间延迟后发起选举
投票过程中收到了 leader 的心跳或消息, 如果任期比自己新, 则自动成为 follower
log 不一致: 只有保存了 log index 最新的的节点才能成为 leader
节点崩溃: RPC 请求会无限重试, 是幂等的

### 客户端请求流程

1. 客户端发起请求
2. leader 收到请求, 记录日志持久化
3. leader 向 follower 发送日志数据 (如果有失败会一直重试)
4. follower 日志持久化, 响应 leader 成功结果
5. leader 接收到所有的 follower 成功响应, 则响应成功结果给客户端

### 脑裂

leader 裂到少节点的区域, 则在多节点区域会产生 new leader, 请求到多节点区域正常处理, 请求到少节点区域会由于 follower 数量不够, 请求处理失败
leader 裂到多节点的区域, 少节点区域无法选举出 new leader, 请求到少节点会失败无法处理, 到多节点区域会正常处理

牺牲部分客户端的可用性, 保障了数据的一致性

## [3] K8S 常用组件, 结构

## 一个请求到达 pod 过程/configmap/dockerfile

## k8s 内部请求到达外部的过程

## 数组和切片的区别

1. 数组长度声明时就要给定, 且之后不能修改
2. 切片的长度通过 append 可以增加
3. 切片可以通过 make([]int, 2, 2) 来创建
4. 切片类型属于引用类型, 是一个指针, 指向底层的数组
5. 切片可以理解为数组的窗口
6. 切片容量不够时, go会生成一个新的切片,会将原来切片上的元素拷贝到新切片中, 一般情况下容量会`*2`, 切片容量>=1024时, 会 `*1.25`,如果容量还不够,会继续按照规则递增
7. 切片容量够用时,append 不会引起扩容
8. 数组是值类型,将一个数组赋值给另一个数组时,实际上是复制了一个新数组
9. 数组作为函数参数时, 函数中会收到数组的拷贝; 切片作为函数参数时, 传递的是指针
10. 数组的长度是 Type 的一部分

### 数组定义

```golang
var a [2]int
var a [...]int{1, 2, 3}
```

### 切片定义

```golang
var b []int
b := make([]int, 3, 5)
```

## 协程同步的方式

1. Mutex 互斥锁
2. 通道
3. sync.WaitGroup
4. context
5. 共享全局变量

## waitgroup 和 context 区别

context 可以协调多个 grooutine 中的代码执行"取消"操作,并且可以储存键值对.是并发安全的. 可以由外部控制 goroutine 的取消.
context 在多个 goroutine 之间共享值,取消信号,deadline 等

waitgroup 用于 goroutine 计数完成等待等操作,goroutine中通过 Done() 方法告知 wg 协程结束. 无法从外部去控制协程的关闭.


## 如何处理异常 defer

defer 中使用 recover() 来获取异常信息

## 通用 http 请求日志打印如何封装

## etcd mvcc , k8s pod 之间如何通信

## [2] go 并发调度模型

1. 使用 groutine 实现的并发
2. go 调度器将多个协程按照一定的算法调度到操作系统的线程上执行.
3. GPM 调度模型
  a. Goroutine (协程): 储存 Goroutine 的运行堆栈,状态以及任务函数, G需要绑定到P才可以被调度执行
  b. Process (逻辑处理器): 提供了执行相关的执行环境(Context),如分配状态(Machine),任务队列(G)等, P数量决定了G并行的上限(前提物理CPU核数>=P数量)
  c. Machine (OS 线程抽象): 真正执行计算的资源
4. goroutine 是轻量级的,开始使用2k大小的栈,后面可以动态调整
5. 低调度成本: 线程在内核切换是依据时间片执行完后的检查,需要保存线程状态,恢复线程时需要从寄存器中恢复状态,所以慢.而 goroutine 是用户层进行调度的,不需要内核上的上下文切换,所以成本低很多.

G队列: 全局队列, P本地队列

M从P中取出(无锁)G来执行, P中没有G使, P会从全局队列中取(有锁)取一个G给M执行, 当全局队列也没有G时, P会从其它的P窃取一个G来给M执行, 都没有G时, PM会解绑,M进入休眠状态.

M的堆栈和M所需的寄存器（SP、PC等）保存到G中，实现现场保护.

使用了m:n调度的技术，即复用或调度m个goroutine到n个OS线程。其中m的调度由Go程序的 runtime 负责，n的调度由OS负责。这让m的调度可以在用户态下完成，不会造成内核态和用户态见的频繁切换。同时，内存的分配和释放，文件的IO等，Go也通过内存池和netpoll等技术，尽量减少内核态的调用。


## go struct 能不能比较?

可以比较的类型: Integer，Floating-point，String，Boolean，Complex(复数型)，Pointer，Channel，Interface，Array
不能比较的类型: Slice，Map，Function

可以通过 `reflect.DeepEqual()` 来比较两个值是否深度一致(结构体中有不可比较的成员也可以进行对比)

有些情况可以比较, 有些情况不能比较

1. 相同类型的结构体, 且结构体成员都是可比较类型, 则可以比较
2. 不同类型的结构体, 通过强制转换类型来尝试比较

## go struct 可以作为 map 的 key 吗?

struct 可以比较时, 可以作为 map 的key

## [2] go defer (for defer)

## [3] select 可以干什么

Select 可以让 Goroutine 同时等待多个 Channel 可读或者可写, 与 epoll 类似, 可以无可读可写时, Select 会阻塞当前线程或 Goroutine

执行判断顺序:

1. 除 default 外，如果只有一个 case 语句评估通过，那么就执行这个case里的语句；
2. 除 default 外，如果有多个 case 语句评估通过，那么通过伪随机的方式随机选一个；
3. 如果 default 外的 case 语句都没有通过评估，那么执行 default 里的语句；
4. 如果没有 default，那么 代码块会被阻塞，指导有一个 case 通过评估；否则一直阻塞

## [4] epoll

## context 包的用途

[参考地址](https://juejin.cn/post/6844903555145400334)

context 用于简化处理多个 goroutine 之间的数据共享,取消信号,截止时间等操作.

Deadline() (deadline time.Time, ok bool) 方法获取设置的截止时间, 一个参数为截止时间, 到了这个时间 ctx 会自动发起取消请求. 如果没有设置截止时间, 那么需要手动调用 cancel() 方法来停止. ok==false时表示没有设置截止时间
Done() <-chan struct{} 是一个只读的 channel, 返回 struct{}, 当有信号时,表明parent context 已经发起了取消, goroutine 中通过 Done chan 获取到取消信号后, 应当做清理操作,然后退出协程,释放资源
Err() error: 返回 ctx 为什么被取消
Value(key interface{}) interface{} : 获取 ctx 上绑定的值, 通常线程安全

golang context的理解，context主要用于父子任务之间的同步取消信号，本质上是一种协程调度的方式。另外在使用context时有两点值得注意：上游任务仅仅使用context通知下游任务不再需要，但不会直接干涉和中断下游任务的执行，由下游任务自行决定后续的处理操作，也就是说context的取消操作是无侵入的；context是线程安全的，因为context本身是不可变的（immutable），因此可以放心地在多个协程中传递使用。

## client 如何实现长连接

## 主协程如何等其余协程完再操作

使用 sync.WithGroup 来控制等待

## slice, len, cap, 共享, 扩容

slice 是 array 的一段的引用

len() 返回元素的数量
cap() 返回切片能够达到的最大长度
共享: 多个切片如果是一个数组的片段, 它们可以共享数据.
优点: 因为切片是引用, 所以不需要额外的内存, 使用起来比数组更有效率.
扩容: slice append 时会发生扩容, 扩容少量元素时(扩容后能容纳append的元素), cap 不够1024的直接翻倍, 大于等于1024的, 乘以1.25
slice append 大量元素, 且按照上述规则无法容纳时,直接使用预估的容量, 新容量会根据切片元素的类型,进行向上取整(内存对齐), 作为新 slice 的容量.

## map 如何实现顺序读取

map 的读取是无序的

转 slice, 排序后再读取

## 实现 set

通过  map[Type]struct{} 来实现 set, struct{} 空结构体在go中不占内存

## 实现消息队列 (多消费者, 多生产者) channel 实现

## 实现循环队列, 保证线程安全 (原子操作和 channel)

## [4] channel 底层实现

## go-micro 使用

## [3] 如何做服务发现

## [2] raft 算法/特点

## go 线上内存泄漏

## k8s 集群网络

## go GMP 源码分析

## go map slice 实现 (源码分析及 slice 内存泄漏分析)

## [2] go 内存逃逸(泄漏)分析

## defer recover 相关问题

## [2] gdb

## docker 预热

## go waitgroup 坑

## 协程 

## 实现协程完美退出

## [3] go 内存分配

## 有 mcentral 为什么要 mcache

## go 协程切换

## go 优缺点

## go 错误处理有什么特点

## mutex 介绍

## bitcask 储存模型细节 既然是追加写，那么如何做旧数据gc？重启后索引怎么恢复？

## LSM tree 与 B+Tree 区别

## map 并发, 为什么用分段锁不用 sync.map? 分段锁拆了几个分片

## TIDB 了解

## newsql 了解

## 项目吞吐量优化

## mmap 操作原理

## mmap 会出现的问题

## 虚拟内存, 缺页置换 MMU

## 共识算法

## 多路复用

## 直接 io 与 mmap 区别

## go 性能调优

## go sync.map

## Go的反射包怎么找到对应的方法

## 退出程序时怎么防止channel没有消费完

## sync.Pool 细节

## 解释 goroutine

## PHP 和 go 对比

## io 模型

## 遇到过的坑

## go 命令

## go 值的传递和引用

## 线程独享什么?

## go new 和 make 区别

new 直接产生变量的指针, 不会产生变量名, 使用场景少

make

## go 如何从源码编译到二进制文件

## go 的锁如何实现, 用了什么 CPU 命令

## go runtime 如何实现

## mysql 连接池实现

## ctx 包的作用

## channel 实现定时器

## go 为什么高并发

## go 回滚

## go interface 理解

## go 闭包函数

## go圣经，深入解析go，go需要高级编程

## Docker 原理

## go 怎么原生支持高并发？

## 用户态和内核态

## 一个main函数内用go 开启多个协程，现在一个协程panic了，main函数会怎样？ 为什么？

## go 优点缺点

优势：容易学习，生产力，并发，动态语法。
劣势：包管理，错误处理，缺乏框架。
