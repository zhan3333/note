# Golang

## 哪些数据类型是引用

go 中四种引用类型有 slice， channel， function， map

## [2] etcd (如何保证高可用, 选举机制, 脑裂如何解决)

### 是什么

分布式, 可靠的 k-v 储存系统

### 如何保证高可用

通过Raft一致性算法处理日志复制以保证强一致性

### [3] raft 选举

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

## [2] 如何处理异常 defer

defer 中使用 recover() 来获取异常信息

## 通用 http 请求日志打印如何封装
 
## etcd mvcc , k8s pod 之间如何通信
 
## [3] go 并发调度模型 (GPM模型)

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

### 为什么这样设计
 
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

1. 函数返回之前指定 defer
2. 逆序执行,像栈一样
3. 未用匿名函数传参使用 defer 时, 变量会直接为 defer 创建时的值
 
## [3] select 可以干什么

Select 可以让 Goroutine 同时等待多个 Channel 可读或者可写, 与 epoll 类似, 可以无可读可写时, Select 会阻塞当前线程或 Goroutine

执行判断顺序:

1. 除 default 外，如果只有一个 case 语句评估通过，那么就执行这个case里的语句；
2. 除 default 外，如果有多个 case 语句评估通过，那么通过伪随机的方式随机选一个；
3. 如果 default 外的 case 语句都没有通过评估，那么执行 default 里的语句；
4. 如果没有 default，那么 代码块会被阻塞，指导有一个 case 通过评估；否则一直阻塞
 
## [4] epoll

event poll, 是事件驱动的, 当 io 事件发生变化时, 会将事件通知给我们

### 两种触发模式:

1. LT (默认)
    只要 fd 有数据, 就会一直返回事件
2. ET 边缘触发模式
    fd 有数据写入时, 只会通知一次(所以需要收到事件时一次性读取完毕)
    效率高, 系统不会充斥大量用户不关心的就绪文件描述符
    
### 优势

1. 没有最大并发数限制, 1G内存下能监听约 10万个端口
2. 效率提升, 使用的是事件通知的模式
3. mmap 减少内存复制开销

## [2] context 包的用途

[参考地址](https://juejin.cn/post/6844903555145400334)

context 用于简化处理多个 goroutine 之间的数据共享,取消信号,截止时间等操作.

Deadline() (deadline time.Time, ok bool) 方法获取设置的截止时间, 一个参数为截止时间, 到了这个时间 ctx 会自动发起取消请求. 如果没有设置截止时间, 那么需要手动调用 cancel() 方法来停止. ok==false时表示没有设置截止时间
Done() <-chan struct{} 是一个只读的 channel, 返回 struct{}, 当有信号时,表明parent context 已经发起了取消, goroutine 中通过 Done chan 获取到取消信号后, 应当做清理操作,然后退出协程,释放资源
Err() error: 返回 ctx 为什么被取消
Value(key interface{}) interface{} : 获取 ctx 上绑定的值, 通常线程安全

golang context的理解，context主要用于父子任务之间的同步取消信号，本质上是一种协程调度的方式。另外在使用context时有两点值得注意：上游任务仅仅使用context通知下游任务不再需要，但不会直接干涉和中断下游任务的执行，由下游任务自行决定后续的处理操作，也就是说context的取消操作是无侵入的；context是线程安全的，因为context本身是不可变的（immutable），因此可以放心地在多个协程中传递使用。

## client 如何实现长连接

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

[示例](./go-producer-consumer-demo/main.go)

## 实现循环队列, 保证线程安全 (原子操作和 channel)

[示例](./circular-queue/main.go)

## [4] channel 底层实现

[参考](https://draveness.me/golang/docs/part3-runtime/ch06-concurrency/golang-channel/)

数据结构: 底层使用循环链表作为缓存结构
发送和接收: 通过 sendx++ 增加接收消息数量, recvx++ 消费消息, 对 buf 加锁, 通过复制内存的方式取得消息 
阻塞: goroutine 会变为 waiting 状态, 空出 M 给其它协程使用.
恢复: chan.sendq list 中会保存 waiting 状态的 goroutine, 通道可用时, 会通知调度器, 将 goroutine 状态置为 runnable, 然后加入 P 中的 runqueue 中, 等待 M 执行
sendx: 发送消息在循环队列下标
recvx: 接收消息在循环队列下标
recvq: 接收者等待双向链表
sendq: 发送者等待双向链表

```go
type hchan struct {
    // Channel 中元素个数
	qcount   uint
    // Channel 中循环队列的长度
	dataqsiz uint
    // Channel 的缓冲区数据指针
	buf      unsafe.Pointer
    // 能够收发的元素大小
	elemsize uint16
    // Channel 是否已经关闭
	closed   uint32
    // 能够收发的元素类型
	elemtype *_type
    // Channel 的发送操作处理到的位置
	sendx    uint
    // Channel 的接收操作处理到的位置
	recvx    uint
	// 由于缓冲区空间不足而阻塞的接收 goroutine 双向链表
	recvq    waitq
    // 由于缓冲区空间不足而阻塞的发送 goroutine 双向链表
	sendq    waitq

	lock mutex
}
```

### 发送数据时

1. 如果当前 Channel 的 recvq 上存在已经被阻塞的 Goroutine，那么会直接将数据发送给当前 Goroutine 并将其设置成下一个运行的 Goroutine；
2. 如果 Channel 存在缓冲区并且其中还有空闲的容量，我们会直接将数据存储到缓冲区 sendx 所在的位置上；
3. 如果不满足上面的两种情况，会创建一个 runtime.sudog 结构并将其加入 Channel 的 sendq 队列中，当前 Goroutine 也会陷入阻塞等待其他的协程从 Channel 接收数据；

发送数据的过程中包含几个会触发 Goroutine 调度的时机：

1. 发送数据时发现 Channel 上存在等待接收数据的 Goroutine，立刻设置处理器的 runnext 属性，但是并不会立刻触发调度；
2. 发送数据时并没有找到接收方并且缓冲区已经满了，这时会将自己加入 Channel 的 sendq 队列并调用 runtime.goparkunlock 触发 Goroutine 的调度让出处理器的使用权；

### 接收数据时

从 Channel 中接收数据时可能会发生的五种情况：

1. 如果 Channel 为空，那么会直接调用 runtime.gopark 挂起当前 Goroutine；
2. 如果 Channel 已经关闭并且缓冲区没有任何数据，runtime.chanrecv 会直接返回；
3. 如果 Channel 的 sendq 队列中存在挂起的 Goroutine，会将 recvx 索引所在的数据拷贝到接收变量所在的内存空间上并将 sendq 队列中 Goroutine 的数据拷贝到缓冲区；
4. 如果 Channel 的缓冲区中包含数据，那么直接读取 recvx 索引对应的数据；
5. 在默认情况下会挂起当前的 Goroutine，将 runtime.sudog 结构加入 recvq 队列并陷入休眠等待调度器的唤醒；

从 Channel 接收数据时，会触发 Goroutine 调度的两个时机：

1. 当 Channel 为空时；
2. 当缓冲区中不存在数据并且也不存在数据的发送者时；

## go-micro 使用

## [3] 如何做服务发现

## go 线上内存泄漏

## k8s 集群网络

## go map slice 实现 (源码分析及 slice 内存泄漏分析)

## [2] go 内存逃逸(泄漏)分析

## [2] gdb

## docker 预热

## [3] 协程 

### 概念

go 协程可以理解为用户态的轻量级的线程, 一个协程可以运行在一个线程上, 也可以运行在不同线程上.

### 切换

协程之间的切换是协程调度器来执行的(GPM)

### 优势

1. 轻量 4k 即可创建, 使用内存可以动态增加
2. 切换成本低, 因为是用户态上的切换, 不需要向线程切换那样的切换上下文
3. 栈管理时自动的, 但是不由垃圾回收器管理, 而是在协程退出后自动释放

## [2] 实现协程完美退出

sync.WaitGroup
context

## [3] go 内存分配

包含三个组件: 用户程序, 分配器, 收集器

### 申请
### 释放
### 分配
### 垃圾回收
### 逃逸分析

### 分配

### 回收

## 有 mcentral 为什么要 mcache

## go 错误处理有什么特点

## bitcask 储存模型细节 既然是追加写，那么如何做旧数据gc？重启后索引怎么恢复？

## LSM tree 与 B+Tree 区别

## map 并发, 为什么用分段锁不用 sync.map? 分段锁拆了几个分片

## TIDB 了解

## newsql 了解

## 项目吞吐量优化

## mmap 操作原理

mmap函数实现把一个文件映射到一个内存区域，从而我们可以像读写内存一样读写文件

## mmap 会出现的问题

## 虚拟内存, 缺页置换 MMU

## 共识算法

## 多路复用

## 直接 io 与 mmap 区别

## go 性能调优

## go sync.map

## Go的反射包怎么找到对应的方法

## 退出程序时怎么防止 channel 没有消费完

先将生产者关闭, 可以通过 close(ch) 来进行

## sync.Pool 细节

## PHP 和 go 对比

## io 模型

## 遇到过的坑

## go 命令

## 线程独享什么?

## go new 和 make 区别

看起来二者没有什么区别，都在堆上分配内存，但是它们的行为不同，适用于不同的类型。

new(T) 为每个新的类型T分配一片内存，初始化为 0 并且返回类型为*T的内存地址：这种方法 返回一个指向类型为 T，值为 0 的地址的指针，它适用于值类型如数组和结构体；它相当于 &T{}。
make(T) 返回一个类型为 T 的初始值，它只适用于3种内建的引用类型：切片、map 和 channel。
换言之，new 函数分配内存，make 函数初始化

如何理解new、make、slice、map、channel的关系

1.slice、map以及channel都是golang内建的一种引用类型，三者在内存中存在多个组成部分， 需要对内存组成部分初始化后才能使用，而make就是对三者进行初始化的一种操作方式

2. new 获取的是存储指定变量内存地址的一个变量，对于变量内部结构并不会执行相应的初始化操作， 所以slice、map、channel需要make进行初始化并获取对应的内存地址，而非new简单的获取内存地址

## go 如何从源码编译到二进制文件

## go 的锁如何实现, 用了什么 CPU 命令

[参考](https://my.oschina.net/renhc/blog/2876211)

### 数据结构

- state int32
    - Waiter: 表示阻塞等待锁的协程个数
    - Starving: 表示 Mutex 是否处于饥饿状态
    - Woken: 是否有在自旋的协程, 目的是告知解锁的协程不需要释放信号量, 因为已经有协程在尝试获取锁了
    - Locked: 0未锁, 1锁, 加锁实际上是给这个部分设置值
- sema uint32

### 加解锁过程

1. 简单加锁: Locked=1
2. 加锁被阻塞: 协程阻塞, Waiter++
3. 简单解锁: Locked=0
4. 解锁并唤醒协程: Waiter--, Locked=1, 通过 释放信号量来通知协程唤醒

### 自旋

如果加锁时发现 Locked==1, 协程会尝试自旋(循环检查Locked), 不会马上进入阻塞, 如果自旋过程中发现锁已被释放, 那么可以立即获取到锁, 这样做的好处是避免协程的切换

自旋对应 CPU 的 PAUSE 指令, CPU 对该指令什么都不做, 相当于 CPU 空转, 目前是 30 个时钟周期

#### 自旋条件

1. 自旋次数足够小, 目前为4
2. CPU 核数要大于1
3. GPM 中的 Process 要大于1
4. GPM 中的可运行队列必须为空, 否则会延迟协程调度

#### 自旋优势

充分利用 CPU, 尽量避免协程切换.

#### 自旋的问题

可能会使阻塞的协程进入饥饿状态, 当 Starving==1 时, 不会自旋, 一定会唤醒一个协程并成功加锁 

### Mutex 模式

- normal 模式: 加锁不成功会自旋
- starvation 模式: 阻塞的协程收到信号量后如果再次阻塞且间隔时间超过 1ms, 则会将 Mutex 标记为饥饿模式go runtime 如何实现

### 为什么不能重复解锁

多次 Unlock() 会多次释放信号量, 会唤醒多个协程, 会引起不必要的协程切换.

## mysql 连接池实现

## channel 实现定时器

## go 为什么高并发

## go 回滚

## go interface 理解

## go 闭包函数

## go圣经，深入解析go，go需要高级编程

## Docker 原理

## go 怎么原生支持高并发？

协程: 用户态的轻量级线程, 调度由用户控制. 协程占用内存小, 上下文切换代价小.
GPM 模型: 任务窃取, 减少阻塞

## 用户态和内核态

内核态: 进程执行系统调用而陷入内核代码中执行时, 乘坐内核态运行
用户态: 进程执行用户自己的代码时, 处于用户运行态

### 用户态切换内核态三种方式

1. 系统调用(主动)
2. 系统异常(被动)
3. 外围设备的中断(被动)


## 一个main函数内用go 开启多个协程，现在一个协程panic了，main函数会怎样？ 为什么？

1. 协程A panic, 协程 B 也会挂掉 (程序会整体退出)
2. 协程A panic, 协程 B 不能用 recover 捕获到协程A 的panic

原因: panic 能够改变程序的控制流, 只能在当前 Goroutine 中的 defer 使用 recover() 处理这个 panic

## [2] go 优点缺点

优势：容易学习，生产力，并发，动态语法。
劣势：包管理，错误处理，缺乏框架。

## 系统信号监听

[go 监听信号](https://gist.github.com/biezhi/74bfe20f9758210c1be18c64e6992a37)

## go sync 包中的锁

[参考](https://juejin.cn/post/6844904147880263694)

`sync.Mutex`: 共享资源上的互斥访问
`sync.RWMutex`: 读写锁, 可以实现共享读
`sync.WaitGroup`: 计数器, 当计数器为0时 `Wait()` 方法会立即返回
`sync.Map`: map 的并发版本, 多读少写的情况下使用这个锁
`sync.Pool`: 并发池, 负责安全的保护一组对象
`sync.Once`: 确保一个函数只执行一次
`sync.Cond`: 阻塞锁, 使用 Wait() 阻塞协程, 用 Signal() 告知一个协程等待解除. 或者用 Broadcast() 告知所有协程等待解除.