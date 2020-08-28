# Golang

## [2] etcd (如何保证高可用, 选举机制, 脑裂如何解决)

## [3] K8S 常用组件, 结构

## 一个请求到达 pod 过程/configmap/dockerfile

## k8s 内部请求到达外部的过程

## 数组和切片的区别

## 协程同步的方式

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