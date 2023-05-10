# Golang

## 细则

[map 专题](./map.md)

## 参考

[go 语言问题集](https://www.bookstack.cn/read/qcrao-Go-Questions/map-map%20%E7%9A%84%E6%89%A9%E5%AE%B9%E8%BF%87%E7%A8%8B%E6%98%AF%E6%80%8E%E6%A0%B7%E7%9A%84.md)

## 哪些数据类型是引用

可以说 GO 传参时始终传递的是值, 只不过有些参数传递的是值, 而有些传递的是指针值(用起来像引用).

种引用类型有 slice， channel， function， map

### slice 传参时是引用

因为 slice 本质上是一个结构体，内部包含一个指向数组的指针，故传参时传的是数组指针，指向的内存一致，相当于引用。

对 slice 容量内的操作会体现到外部，但是一旦发送扩容，指向的数组就会变。

### map 传参时是引用

make(map) 或者 var m = map[string]string 时， 获取到的 map 实际上就是一个指针，同样的 chan 创建时就是一个指针，故可以理解为引用。

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

### ETCD 分布式锁

ETCD 支持以下功能，用于实现分布式锁:

1. 租约机制
2. 续约机制
3. key 递增版本id机制 (Revision) (设置 key 成功时，将返回 revision 给客户端，可以用于区分是否是自己的锁)
4. 获取锁的顺序性 (多个程序同时抢锁时，会按照 Revision 大小依次获取锁，避免惊群效应)
5. Watch 机制 (客户端将收到 key 变化的通知)
6. Prefix 机制 (可以设置多个锁)

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
 
## 为什么设计 Goroutine

1. Thread 太重， 包含了各种信号控制、上下文切换、各种控制信息等，默认占用栈大小 1M，无法大量创建线程。
2. Thread 切换开销大，thread 切换需要穿过用户态到达内核态。
3. Thread 间通信困难
4. Thread 创建回收非常复杂
5. 无法满足 GC 的需求

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

使用 ETCD, 包含 服务注册, 服务发现, 健康检查

### 流程

启动 ETCD, 服务启动时会向 ETCD 发起注册请求, 并且启动健康检查, 从 ETCD 中获取依赖的其他服务信息

### 作用

- kv 数据库
- 分布式锁
- watch
- 健康检查
- 值版本
- 强一致
- 高可用

## [4] Go 线上内存泄漏(逃逸)

[参考](https://segmentfault.com/a/1190000019222661)

### 内存泄露是什么

内存泄露是指程序运行过程中已不再使用的内存，但是没有及时的被释放掉，导致这些内存无法被使用。

### 如何发现内存泄露

1. 监控程序
2. pprof

### 内存泄露两种方式

1. goroutine 本身占用栈空间
2. goroutine 中变量占用的堆内存导致内存泄露

## slice 和 array 区别

array 是固定长度的数组, 使用前必须确定数组的长度

array 特点:

- array 是值类型, 当一个数组赋值给另一个数组时, 会拷贝, 使用新的内存空间
- 数组作为函数的参数, 实际上是进行了拷贝
- array 的长度是作为 Type 的一部分, [10]int 和 [20]int 是不一样的

slice 特点:

- slice 是引用类型, 是一个动态的指向数组切片的指针
- slice 是一个不定长的, 总是指向底层的 array 的数据结构

区别:

- 声明时, array 需要有声明长度或者 `...`
- 作为函数的参数时, array 传递的是数组的副本, slice 传递的是指针

## slice 底层实现

slice 是数组的引用

```go
type SliceHeader struct {
    // 指向数组的指针
	Data uintptr
    // 当前切片的长度
	Len  int
    // 当前切片的容量, 即 Data 数组的大小
	Cap  int
} 
```

在分配内存空间之前需要先确定新的切片容量，运行时根据切片的当前容量选择不同的策略进行扩容：

1. 如果期望容量大于当前容量的两倍就会使用期望容量；
2. 如果当前切片的长度小于 1024 就会将容量翻倍；
3. 如果当前切片的长度大于 1024 就会每次增加 25% 的容量，直到新容量大于期望容量；

需要根据切片中的元素大小对齐内存，当数组中元素所占的字节大小为 1、8 或者 2 的倍数时，运行时会对齐内存

append() 覆盖原变量时, 编译器会进行优化.

## map 底层实现

map 是哈希表的实现, 表示键值对的映射关系

哈希函数: 需要均匀的哈希函数结果, 避免冲突

解决冲突

1. 开放寻址法: 写入时发生冲突, 就会将键值写入到下一个索引不为空的位置
2. 拉链法: 使用链表来处理冲突的数据

扩容触发条件:

0. (前置条件)没有正在进行扩容
1. 装载因子已经超过 6.5
2. 哈希使用了太多溢出桶

增量扩容: 每一次 map 操作行为去分摊总的一次性操作, 迁移是逐步完成的
扩容中又需要扩容: 会将前一次的扩容完成, 然后开始这一次扩容

## [2] gdb

断点调试

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

Go 实现的内存管理简单的说就是维护一大块全局内存, 每个线程 (Go 中的P) 维护一块小的私有内存, 私有内存不足时再从全局申请.

- Go 程序启动时申请一大块内存, 并划分成 spans, bitmap, arena 区域
- arean 区域按页划分成一个个小块
- span 管理一个或多个页
- mcentral 管理多个 span 供线程申请使用
- mcache 作为线程私有资源, 资源来源于 mcentral

### 垃圾回收

常见垃圾回收算法

- 引用计数: 每个对象维护一个引用计数, 当引用该对象的对象被销毁时, 引用计数减一, 当引用计数为0时回收该对象.
    - 优点: 对象可以很快的被回收, 不会出现内存耗尽或者到达某个阈值时才回收.
    - 缺点: 不能很好的处理循环引用, 而且实时的维护引用计数, 也有一定的代价
    - 代表语言: PHP, Python, Swift
- 标记-清除: 从根遍历所有引用的对象, 引用对象被标记为 `被引用` , 没有被标记的进行回收.
    - 优点: 解决了引用计数的缺点
    - 缺点: 需要 STW (Stop The World), 就是停掉所有的 goroutine, 专心做垃圾回收, 待垃圾回收结束后再回复 goroutine, 这会导致程序短时间的暂停
    - 代表语言: Go (三色标记法)
- 分代收集: 按照对象生命周期的长短划分不同的代空间, 生命周期长的放入老年代, 而短的放入新生代, 不同代有不同的回收算法和回收频率
    - 优点: 回收性能好
    - 缺点: 回收算法复杂
    - 代表语言: Java
    
#### Go 垃圾回收的三色标记法

三色标记法只是为了描述方便抽象出来的一种说法, 实际上对象并没有颜色之分. 这里的三色对应了垃圾回收过程中对象的三种状态:

- 灰色: 对象还在标记队列中等待
- 黑色: 对象已经被标记, gcmarkBits 对应的位为1 (对象不会在本次 GC 中被清理)
- 白色: 对象未被标记, gcmarkBits 对应的位为0 (对象会在本次 GC 中被清理)

#### 垃圾回收优化

##### 写屏障

STW 的目的是防止 GC 在扫描时内存变化而停掉 Goroutine, 而写屏障就是让 Goroutine 与 GC 同时运行的手段. 虽然写屏障不能完全消除 STW, 但是可以大大减少 STW 的时间.

写屏障类似一种开关,在 GC 的特定时机开启, 开启后指针传递时会把指针标记, 即本轮不回收, 下次 GC 时再确定.

GC 过程中心分配的内存会被立即标记, 用的并不是写屏障技术, 也即 GC 过程中分配的内存不会在本轮 GC 中回收.

##### 辅助 GC (Mutator Assist)

为了防止内存分配过快, 在 GC 执行过程中, 如果 Goroutine 需要分配内存, 那么这个 Goroutine 会参与一部分 GC 的工作, 即帮助 GC 做一部分工作, 这个机制叫做 Mutator Assist

#### 垃圾回收触发时机

##### 内存分配量达到阈值触发 GC

每次内存分配时都会检查当前内存分配量是否已经达到阈值, 如果达到阈值则立即启动 GC.

> 阈值 = 上次 GC 内存分配量 + 内存增长率

内存增长率由环境变量 `GOGC` 控制, 默认为 100, 即每当内存扩大一倍时启动 GC.

##### 定期触发 GC

默认情况下, 最长2分钟触发一次 GC, 这个间隔在 `src/runtime/proc.go:forcegcperiod` 变量中被声明

##### 手动触发

程序代码中可以使用 `runtime.GC()` 来手动触发 GC, 这主要用于 GC 性能测试和统计

#### Go 性能优化

GC 性能和对象数量负相关, 对象越多 GC 性能越差, 对程序影响越大

所以 GC 性能优化的思路之一就是减少对象分配个数, 比如对象复用或者使用大对象组合多个小对象等.

另外, 由于内存逃逸现象, 有些隐式的内存分配也会产生, 也有可能成为 GC 的负担

> 内存逃逸现象: 变量分配在栈上需要能在编译器确定它的作用于, 否则就会被分配在堆上. 而堆上动态分配内存比栈上静态分配内存, 开销大很多.


##### 逃逸分析的作用

1. 逃逸分析的好处是减少 GC 压力, 不逃逸的对象分配在栈上, 当函数返回时就回收了资源, 不需要 GC 标记清除.
2. 逃逸分析完后可以确定哪些变量可以分配在栈上, 栈的分配比堆快, 性能好 (逃逸的局部变量只会分配在堆上, 没有发生逃逸的则由编译器分配到栈上)
3. 同步消除, 如果你定义的对象在方法上有同步锁, 但咋运行时, 却只有一个线程在访问, 此时逃逸分析后的机器码, 会去掉同步运行锁

场景

变量作为返回值

[参考](https://segmentfault.com/a/1190000023595055)

##### 逃逸总结

- 栈上分配内存比在堆中分配内存有更高的效率
- 栈上分配内存不需要 GC 处理
- 堆上分配的内存使用完毕会交给 GC 处理
- 逃逸分析的目的是决定内存分配到堆还是栈
- 逃逸分析在编译阶段完成
 
## 有了 mcentral 为什么要 mcache

## go 错误处理有什么特点

1. 使用接口 error 来定义错误
2. 要求 error 在程序中要么处理掉, 要么返回给上层, 不允许忽略
3. 使用 error type 来区分错误
4. 可预料的问题可以定义为 error, 不可预料的问题才用 panic

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

分布式一致性算法

## 多路复用

## 直接 io 与 mmap 区别

## go 性能调优

## go sync.map

是一种类型, 与 map 结构类似, 提供方法(`Store, Load, Delete`)来操作 map, 这些操作是并发安全的.

缺点: 相对于 map 有一定的性能损失
优点: 动态扩容, 锁粒度在数据的状态上, 大多数数据可以做到无锁化

### map 分段锁

使用一组 map 来储存键值, 使用 `sync.RWMutex` 来进行锁操作, 通过 hash 算法来决定 key 在哪个 map 中操作

优势: 降低锁的粒度, 提高性能
缺点: 由于需要提前确定分片数量, 所以扩容缩小困难

### 为什么使用分段锁不使用 sync.Map?

## Go的反射包怎么找到对应的方法

## 退出程序时怎么防止 channel 没有消费完

先将生产者关闭, 可以通过 close(ch) 来进行

## sync.Pool 细节

## PHP 和 go 对比

## io 模型

## 遇到过的坑

1. slice 引用
2. 多维 slice 初始化
3. string 长度: len() 返回字符串的 byte 数量, 统计字符数应该使用 `RuneCountInString(str string)`
4. map range 每次顺序都会变化
5. switch case 默认有 break, 可以使用 `fallthrough` 强制执行下一个 case
6. 不导出的 struct 字段无法被 encode
7. main 退出时, 可能还有 goroutine 在执行
8. wg 需要引用传递才能使用
9. struct 在所有成员都可以比较的情况下才可以比较
10. recover() 仅在 defer 中才能生效, 且 recover 需要与 代码间隔一个层
11. range 迭代 slice, array, map 时不能够通过引用来修改值, 因为值都是拷贝
12. slice 底层使用的是 array, 从一个 array 创建出来的 slice 变更时会互相影响
13. defer 在声明时就会将参数求出具体的值
14. map 中不可寻址 struct 不可调用 指针参数的 receiver
15. map 不可以直接操作 不可寻址的 struct 成员
16. 多个 goroutine 中的操作不一定是有序的
17. for {} 会阻止调度器运行, 故需要在其中调用 `runtime.Gosched()` 来使调度器能够启动运行

## go 命令

## 线程独享什么?

### 共享

1. 进程代码段
2. 进程共有数据 (全局变量, 静态变量)
3. 进程打开的文件描述符
4. 信号的处理器
5. 进程的当前目录
6. 进程用户 ID 与 进程组 ID
7. 堆

### 独享

1. 线程ID
2. 寄存器
3. 线程的堆栈
4. 错误返回码
5. 线程优先级
6. 程序计数器

## go new 和 make 区别

看起来二者没有什么区别，都在堆上分配内存，但是它们的行为不同，适用于不同的类型。

new(T) 为每个新的类型T分配一片内存，初始化为 0 并且返回类型为*T的内存地址：这种方法 返回一个指向类型为 T，值为 0 的地址的指针，它适用于值类型如数组和结构体；它相当于 &T{}。
make(T) 返回一个类型为 T 的初始值，它只适用于3种内建的引用类型：切片、map 和 channel。
换言之，new 函数分配内存，make 函数初始化

如何理解new、make、slice、map、channel的关系

1.slice、map以及channel都是golang内建的一种引用类型，三者在内存中存在多个组成部分， 需要对内存组成部分初始化后才能使用，而make就是对三者进行初始化的一种操作方式

2. new 获取的是存储指定变量内存地址的一个变量，对于变量内部结构并不会执行相应的初始化操作， 所以slice、map、channel需要make进行初始化并获取对应的内存地址，而非new简单的获取内存地址

## go 如何从源码编译到二进制文件

源代码 -> AST 语法树 -> 机器码

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

```golang
func delay(duration time.Duration, callback func()) {
	ch := make(chan struct{})
	go func(ch chan struct{}) {
		<-ch
		callback()
	}(ch)
	go func(ch chan struct{}) {
		time.Sleep(duration)
		ch <- struct{}{}
	}(ch)
}
```

## [2] go 为什么高并发

1. goroutine
    a. 上下文切换成本小
    b. 占用内存小
2. GPM 模型

协程: 用户态的轻量级线程, 调度由用户控制. 协程占用内存小, 上下文切换代价小.
GPM 模型: 任务窃取, 减少阻塞

## go 回滚

使用 defer, 再回退过程中检查 err 是否不为 nil 来进行回退

## go interface 理解

隐式的实现接口, 多个类型可以实现同一个接口

实现接口的类型可以拥有其他方法

类型可以实现多个接口

接口可以先实现再定义 

接口可以嵌套接口

## go 闭包函数

匿名函数, 常用语 defer 和 goroutine, 通常立即执行, 或者赋值给变量, 然后通过调用变量的方式调用匿名函数.

闭包可以捕捉到一些外部状态(函数被创建时的状态)

## go圣经，深入解析go，go需要高级编程

## 用户态和内核态

内核态: 进程执行系统调用而陷入内核代码中执行时, 称作内核态运行
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

## struct 和 OOP 使用中有什么区别

OOP 特点: 封装, 继承, 多态

继承: 一个对象获得另一个对象的属性的过程

- Java 只有单继承, 接口多实现
- Go 可以实现多继承
    - 一个 struct 嵌套了另一个匿名 struct, 那么这个 struct 可以直接访问匿名机构提的方法, 从而实现继承
    - 一个 struct 嵌套了另一个命名 struct, 那么这个模式叫做组合
    - 一个 struct 嵌套了多个匿名 struct, 那么这个结构可以直接访问多个匿名 struct 的方法, 从而实现多重继承
    
封装: 自包含的黑盒子, 有私有和公有部分, 公有可以被访问, 私有的外部不能访问.

- Java 中访问权限控制通过 public, protected, private 等关键字控制
- Go 通过约定来实现权限控制, 变量名字母大写相当于 public, 小写相当于 private.

多态: 允许用于一个接口在访问同一类动作的特性

- Java 中的多态是通过 extends class 或者 implements interface 实现
- Go 中的 interface 通过 `合约` 方式实现, 只要某个 struct 实现了某个 interface 中的所有方法, 那么它就隐式的实现了这个接口

## 对 channel 的理解

channel 是一种通信机制, 它可以让一个 goroutine 通过它给另一个 goroutine 发送值消息, 每个 channel 都有一个特殊的类型, 也就是 channel 允许发送的数据类型.

### channel 有哪些状态

- nil, 未初始化状态, 只进行了声明, 或者手动赋值为 nil
- active, 正常的 channel, 可读可写
- closed, 已关闭

### channel 可进行的三种操作
 
- 读
- 写
- 关闭

组合出来9中情况

|操作|nil的channel|正常的channel|已关闭的channel|
|---|---|---|---|
|<-ch 读|阻塞|成功或者阻塞|读到零值|
|->ch 写|阻塞|成功或者阻塞|panic|
|close(ch) 关闭|panic|成功|panic|

## 并发状态下 map 如何保证线程安全

Go 的 map 并发访问是不安全的, 会出现未定义行为, 导致程度退出

两种处理方式

1. 使用 `sync.RWMutex`
2. 使用 `sync.Map`

`sync.Map` 实现有几个优化点:

1. 空间换时间. 通过冗余的两个数据结构 (read, dirty), 实现加锁对性能的影响
2. 使用只读数据 (read), 避免读写冲突
3. 动态调整, miss 次数多了之后, 将 dirty 数据提升为 read
4. double-checking
5. 延迟删除. 删除一个键值只打标记, 只有在提升 dirty 的时候才清理删除的数据
6. 优先从 read 读取, 更新, 删除. 因为对 read 的读取不需要锁

## 讲讲对 gin 框架的理解

gin 是一个 go 的微框架, API 友好. 快速灵活. 容错方便等特点

其实对于 go 而言, 对 web 框架的依赖远比 Python, Java 之类的小. 本身的 `net/http` 足够简单, 而且性能也非常不错, 大部分的框架都是对 `net/http` 的封装. 所以 gin 框架更像是一些常用函数或者工具的集合. 使用 gin 框架开发, 可以提升效率, 并统一团队的编码风格.

### gin 的路由组件为什么高性能

#### 路由树

gin 使用高性能的 `httprouter`

在 gin 框架中, 路由规则被分成了 9 颗前缀树, 每一个 HTTP Method 对应一棵前缀树, 树的节点按照 URL 中的 / 符号进行层级划分

#### gin.RouterGroup

RouterGroup 是对路由树的包装, 所有的路由规则最终都是由它来进行管理. Engine 结构体继承了 RouterGroup, 所以 Engine 直接具备了 RouterGroup 所有的路由管理功能.

#### gin 数据绑定

gin 提供了很方便的数据绑定功能, 可以将用户传过来的参数自动跟我们定义的结构体绑定在一起, 这也是我们选用 gin 的重要原因.

#### gin 数据验证

在上面绑定的基础上, gin 还提供了数据校验的方法. gin 的数据验证和数据绑定是结合在一起的. 只需要在数据绑定的结构体成员变量的标签添加 `binding` 规则即可. 减少了大量的验证工作.

#### gin 的中间件

gin 中间件利用函数调用栈 `后进先出` 的特点, 完成中间件在自定义处理函数完成后的处理操作

## 内存泄漏

## go 性能问题的定位过程（pprof的使用）

## reflect 的使用

## 协程池的使用

## go string 与 []byte 互转以及风险

[string & []byte 互转](https://segmentfault.com/a/1190000037679588)

源码看: src/runtime/string.go stringtoslicebyte / slicebytetostring

string 是不可变的，[]byte 是可变的，在 []byte -> string 的强制转换场景中，如果更改了 []byte，会产生无法捕获的错误。

标准转换中:

- string -> []byte: 由于 string 是不可变的，所以新的 []byte 直接改为指向 string 底层的 []byte 完成转换。当 string len > 32 时，会发生一次 mallocgc() 为 slice 重新分配内存。
- []byte -> string: 通过 memmove() 进行 byte copy 到 string。当 slice len > 32 时会发生一次 mallocgc() 内存分配。

强制转换中:

- string -> []byte: slice 底层 array 指针直接指指向 string 底层 array (与标准转换看起来逻辑一致，没有内存 copy)
- []byte -> string: string 底层 array 指针直接指向 slice 底层 array