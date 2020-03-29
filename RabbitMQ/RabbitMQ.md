# RabbitMQ

消息队列主要解决耦合, 异步处理, 流量削峰等问题



## 问题

### 几种消息队列的对比

- RabbitMQ
    - Erlang
    - 支持多种语言
    - 多协议支持 AMQP, XMPP< SMTP, STOMP
    - 不支持批量消息操作
    - master/slave, slave 只做备份
    - 万级消息吞吐量
    - 微妙级消息延迟
    - 事务: 支持
    - 支持均衡负载
    - 支持集群
    - 持久化能力: 内存,文件, 支持数据堆积, 但数据堆积反过来影响生产效率
    - 是否有序: 若想有序, 只能用一个 Client

- ActiveMQ
    - Java
    - 多语言支持
    - 协议支持: OpenWire, STOMP, REST, XMPP, AMQP
    - 消息批量操作: 支持
    - 消息推拉模式: 多协议,Pull/Push 均支持
    - HA: 基于 ZooKeeper + LevelDB 的 Master-Slave 实现模式
    - 数据可靠性: master/slave
    - 单机吞吐量: 万级(最差)
    - 持久化能力: 内存,文件,数据库
    - 集群: 支持
    - 负载均衡: 支持
    - 管理界面: 一般

- RocketMQ
    - Java
    - 支持语言: Java, C++(不成熟)
    - 协议支持: 自己定义的一套(社区提供的 JMS 不成熟)
    - 消息批量操作: 支持
    - 消息推拉模式: 多协议, Pull/Push 都支持
    - HA: 支持多 Master 模式, 多 Master 多 Slave 模式, 异步复制模式, 多 Master 多 Slave 模式, 同步双写
    - 数据可靠性: 支持异步实时刷盘, 同步刷盘, 同步复制, 异步复制
    - 单机吞吐量: 最高(十万级)
    - 持久化能力: 磁盘
    - 是否有序: 有序
    - 事务: 支持
    - 均衡负载: 支持
    - 管理界面: 命令行界面
    
- Kafka
    - Scala & Java
    - 官方支持 Java, 开源社区有多语言版本
    - 协议支持: 自有协议, 社区封装了 HTTP 协议
    - 消息批量操作: 支持
    - 消息推拉模式: Pull
    - HA: 支持 repllca 机制, leader 宕机后, 备份自动顶替, 并重新选举 leader (基于 Zookeeper)
    - 数据可靠性: 数据可靠, 并且有 repllca 机制, 有容错容灾能力
    - 单机吞吐量: 次之(十万级)
    - 消息延迟: 毫秒级
    - 事务: 不支持, 但可以通过 Low Level API 保证仅消费一次
    - 集群: 支持
    - 负载均衡: 支持
    - 管理界面: 官网命令行, 有开源界面

### RabbitMQ 的应用场景

1. 非实时性: 不需要立即获得结果
2. 应用耦合: 多应用间通过队列对同一任务进行处理, 避免一失败全失败
3. 异步处理: 多应用对同一消息进行处理, 应用间并发处理消息.
4. 限流削峰: 应用于秒杀或者抢购活动中, 避免流量过大导致应用挂掉的情况.
5. 消息驱动的系统: 系统分为消息队列, 生产者, 消费者等.

对比 Kafka:

RabbitMQ: 遵循 AMQP 协议, 由内在高并发的 erlang 语言开发, 用在实时的对可靠性要求比较高的消息传递上
Kafka 主要用于处理活跃的流式数据, 大数据量的数据处理上

### RabbitMQ 对比 Kafka

- 优先级队列
    - RabbitMQ 支持
    - Kafka 不支持
- 延迟队列
    - RabbitMQ 支持
- 死信队列
    - RabbitMQ 支持
- 重试队列
    - 不支持 (但是可以通过延迟队列来实现重试队列)
- 消费模式
    - RabbitMQ: Push/Pull 模式
    - Kafka: Pull
- 广播消费
    - RabbitMQ: 支持, 但力度较 Kafka 弱
    - Kafka: 支持
- 消息回溯
    - RabbitMQ: 不支持, 消息一旦被确认消费就会被标记删除
    - Kafka 支持按照 offset 和 timestamp 两种维度进行消息回溯
- 消息堆积
    - RabbitMQ: 支持, 一般情况下, 内存堆积达到特定阈值时会影响其性能, 但不是绝对的, 如果考虑到吞吐这因素, Kafka 的堆积效率比 RabbitMQ 总体上要高很多
    - Kafka: 支持
- 持久化
    - RabbitMQ: 支持
    - Kafka: 支持
- 消息追踪
    - RabbitMq: 支持. 可以采用 Firehose 或者 rabbitmq_tracing 插件实现. 不过开启 rabbitmq_tracing 插件会大幅度影响性能, 不建议生产环境开启, 反倒是可以使用 Firehost 与 外部链路系统结合提供高细腻度的消息追踪支持.
    - Kafka: 不支持. 但是可以通过外部系统来支持
- 消息过滤
    - RabbitMQ: 不支持, 但是可以封装
    - Kafka: 客户端级别的支持
- 多租户:
    - RabbitMQ: 支持
    - Kafka: 不支持
- 多协议支持:
    - RabbitMQ: 本身就是 AMQP 协议的实现, 同时支持 MQTT, STOMP 等协议
    - Kafka: 只支持定义协议, 目前在几个主流版本间存在兼容性问题
- 跨语言支持
    - RabbitMQ: 采用 Erlang 编写, 支持多种语言的客户端
    - Kafka: 采用 Scala 和 Java 编写, 支持多种语言的客户端
- 流量控制
    - RabbitMQ: 基于 Credit-Based 算法, 是内部被动触发的保护机制, 作用于生产者层面.
    - Kafka: 支持 client 和 user 级别, 通过主动设置可将流控作用于生产者或消费者
- 消息顺序性
    - RabbitMQ: 顺序性的条件比较苛刻, 需要单线程来发送, 单线程消费并不采用延迟队列, 优先级队列等一些高级功能, 从某种意义上来说不算支持顺序性.
    - Kafka: 支持单分区(partition)级别的顺序性
- 安全机制
    - RabbitMQ: 和 Kafka 类似
    - Kafka: TLS/SSL, SASL 身份认证和 读写控制权
- 幂等性
    - RabbitMQ: 不支持
    - Kafka: 支持单个生产者分区单会话的幂等性
- 事务性消息
    - RabbitMQ: 支持
    - Kafka: 支持

### 如果不用消息队列, 项目中会怎么实现对应功能?
### RabbitMQ 内部使用原理? 工作流程?
### RabbitMQ 如何保证的数据可靠性?
### RabbitMQ 中各种名词之间的关系 

- Broker: 简单来说就是消息队列服务器实体
- Exchange: 消息交换机, 它指定消息按什么规则, 路由到哪个队列
- Queue: 消息队列载体, 每个消息都会被投入到一个或多个队列
- Binding: 绑定, 它的作用就是把 exchange 和 queue 按照路由规则绑定起来
- Routing Key: 路由关键字, exchange 根据这个关键字进行消息投递
- vhost: 虚拟主机, 一个 broker 里可以开设多个 vhost, 用作不同用户的权限分离
- producer: 消息生产者, 就是投递消息的程序
- consumer: 消息消费者, 就是接受消息的程序
- channel: 消息通道, 在客户端的每个连接里, 可建立多个 channel, 每个 channel 代表一个会话任务

### 使用流程

1. client 连接到消息队列服务器, 打开一个 channel
2. client 声明一个 exchange, 并设置相关属性
3. client 声明一个 queue, 并设置相关属性
4. client 使用 routing key, 在 exchange 和 queue 之间建立好绑定关系
5. client 投递消息到 exchange
6. exchange 接收到消息后, 就根据消息 key 和已经设置的 binding, 进行消息路由, 将消息投递到一个或多个队列里.

