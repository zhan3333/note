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

## 如何处理异常 defer

## 通用 http 请求日志打印如何封装

## etcd mvcc , k8s pod 之间如何通信

## [2] go 的调度模型

## go struct 能不能比较?

## [2] go defer (for defer)

## [3] select 可以干什么

## [4] epoll

## context 包的用途

## client 如何实现长连接

## 主协程如何等其余协程完再操作

## slice, len, cap, 共享, 扩容

## map 如何实现顺序读取

## 实现 set

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