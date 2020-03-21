# Redis

## 常见问题

### Redis 延时队列

使用 `sortedset` , 时间戳作为 score, 消息内容作为key, 调用zadd来生产消息, 通过 zrangebyscore 来获取范围内的消息

### Redis 做异步队列

使用 `list` 来做异步队列, rpush生产消息, lpop消费消息, 缺点在于消费者挂掉时, 消息会丢失, 所以推荐使用 `rabbitMQ` 等专业队列. 当没有消息时, 需要sleep一段时间, 或者使用 blpop 在没有消息时, 会一直阻塞住.
还可以通过 `sub/pub`主题订阅模式, 达到一个消息多次消费的效果. 消费者下线后, 消息也会丢失.

### Redis 查大量数据

假设Redis中有1亿数据, 其中有10w条数据key的前缀是相同的, 如何查阅这些数据?
由于redis是单线程的, 当有业务在运行时, 直接使用keys命令会导致一段时间的不可用, 所以推荐使用 scan 命令, 虽然会查出来一定的重复key, 但是可以在客户端去重即可, 这样对生产的影响会降低.

### Redis 有哪些数据结构

`String`

字符串, 单个key最大储存 512M

`List`

列表

`Hash`

哈希

`Set`

无须集合

`Sort Set`

有序集合

`Pub/Sub`

订阅消费者模式

`Geo`

储存地理位置, 可以计算两个地理点的3D距离

`HyperLogLog` 

基数统计算法, 是一种概率算法, 用来统计大量的数据的统计结果, 并不储存具体的键. 在 redis 中, 只需要 12k 内存就可以储存理论上接近 2^64 个不同元素的基数. 在储存的元素数量或者体积非常大时, 使用的空间总是固定的, 并且是很小的.

应用: 一般用于统计注册IP数, 每日页面访问数等

### Redis 数据淘汰策略

系统默认 `no-eviction`

1. `voltile-lru` 在设置了过期时间的数据中, 淘汰最近最少使用的数据
2. `voltile-ttl` 淘汰将设置了过期时间的数据, ttl大的优先淘汰 (即最接近过期的)
3. `voltile-random` 随机淘汰设置了过期时间的数据
4. `allkeys-lru` 淘汰最近最少使用的数据
5. `allkeys-random` 任意选择淘汰
6. `no-eviction` 禁止淘汰, 当内存不足时写入数据, 会返回错误

### Redis 三种淘汰机制

1. `LRU (Least recently used 最近最少使用) `
2. `TTL`
3. `Random`

### Redis 订阅发布机制

两种订阅模式:

1. `channel` 频道订阅模式, 例如订阅了 A 频道, 则 A 频道发布消息时, 订阅者都可以收到
2. `pattern` glob-style 模式, 及匹配模式, 例如订阅了 *.news, China.news, America.news 发布消息时, 订阅了这个频道的人都会收到

### Redis 主从复制

### Redis 性能优化

1. master 最好不做持久化工作, 交给 slave 来做
2. 为了主从复制的速度和连接的稳定性, master 和 slave 最好在同一个局域网内
3. 尽量避免在压力大的主库上增加从库
4. 主从复制尽量不采用网状结构, 而是线性结构, master->slave1->slave2->...

### 缓存与数据库数据不一致怎么办

假设使用的主存分离, 读写分离的数据库.

发生的可能性: 

1. 主库更新数据, 主库到从库的同步未完成, 从库读取数据, 未读到最新数据, 而更新了缓存

解决方案: 在从库接收到数据更新操作时, 淘汰掉这条数据的缓存

解决方案: 

1. 在数据性一致性要求不高时, 忽略掉这个数据的不一致
2. 延时双删策略
    1. 先删除缓存
    2. 再写数据库
    3. 休眠500毫秒
    4. 再次删除缓存
    5. 设置缓存过期时间
4. 异步更新缓存(基于订阅binlog的同步机制)
    1. Redis订阅 mysql binlog消息
    2. 依据消息来进行相关操作
    

### Redis 缓存穿透

起因: 恶意请求故意大量查询不存在的key, 让请求到达MySQL, 对后端造成很大压力
解决方案: 对不存在的key也做有有效期的缓存; 对存在的key放到一个bitmap来储存, 查询时通过bitmap过滤.

### Redis 缓存雪崩

起因: 大量的缓存在同一时间段失效, 导致后端压力大.
解决方案: 对缓存的有效时间使用不同的过期时间; 做二级缓存; 

### Redis 主从复制的实现

1. 主节点将内存中的数据做一个快照, 发送给从节点, 从节点将数据恢复到内存中.
2. 之后每次增加新数据, 主节点以类似 mysql 的二进制日志方式将语句发送给从节点, 从节点拿到主节点发送过来的语句进行重放.

### Redis 分布式锁

> 为什么要分布式锁

为了确保在多个线程中, 多服务器中执行任务时, 能够达到一致性

> Redis 为什么可以做分布式锁

Redis 是单线程的(网络请求模块使用了一个线程, 所以不需要考虑并发性), 即一个线程处理所有网络请求, 其它模块仍用了多个线程.

> 如何用

使用 `setnx key value`即加锁, 其它线程再来设置会返回false
`del key` 释放锁

> 解决死锁

1. Redis控制: 使用 `setnx key value` 后, 立即使用 `expire key timeout` 设置有效期.
2. 其它服务器控制: 通过 `value` 设置为失效时的时间戳(比如当前+1s), 其它服务器在获取锁时发现锁还在, 且超过了有效期, 就直接来释放锁, 在释放锁这个过程, 需要使用 `GETSET key value` 来操作, 直接对这个key进行`getset`, 看返回值如果是过期的, 说明拿到了锁, 反之拿失败了. 拿失败的情况下, 需要放弃后续的操作了

> 缺陷

当master上加了锁, 还未同步到 slave 时, master down了, 这个时候 slave 成为了 master, 其中并没有锁, 这个时候就会出现多个客户端同时拿到锁的问题.

> 锁延期机制 (watch dog)

当客户端超过了key的生存时间还在操作, 想要继续有这个锁, 那么可以使用看门狗程序, 在生存时间内会定时查这个锁是否还在, 还在的话就延期

### Redis 做内存优化

1. 尽可能使用散列表

### Redis key 过期时间和永久有效设置

设置过期时间 `EXPIRE key seconds`
设置永久有效 `PERSIST key`

### Redis 事务

Redis事务保证了命令的打包操作, 其中的一个命令失败不会回滚, 也不会影响下一个命令的执行, 只是打包操作了, 保证了在执行过程中, 不会有其它命令的插入

使用 `MULTI` 开始一个事务
使用 `EXEC` 执行事务

### Redis 管道

一次请求/响应服务器能实现处理新的请求即使旧的请求还未被响应,这样就可以将多个命令发送到服务器, 而不用等待回复, 最后在一个步骤中读取该答复.

### Redis 集群

> 集群最大节点数

16384个

> 集群之间是如何复制的

异步复制

### Redis 应用

- 队列 (List)
- 排行榜/计数器 (SortedSet)
- 全页缓存 (FPC) 缓存页面
- 会话缓存 (缓存Session)

### Redis 为什么把数据都放在内存中

为了达到最快的读写速度, 并通过异步的方式将数据写入磁盘.

磁盘 I/O 会严重影响 redis 的性能

### (2) Redis 的了解

Redis 是一款高性能的缓存储存系统, 支持多种数据格式, 能够持久化, 分布式

### (4) Redis 持久化有哪几种方式? 怎么选?

- 快照 (RDB文件)
    - 简介: 固定时间全盘备份
    - 原理
        - Redis 调用 fork(), 产生一个子进程
        - 子进程将数据写到一个临时的 RDB 文件
        - 当子进程写完新的 RDB 文件后, 把旧的 RDB 文件替换掉
    - 优点
        - RDB 单文件, 简洁, 很适合用作备份.
        - 适用于灾备
        - 性能好, 需要持久化时, 主进程会 fork 一个主进程出来, 自己不会进行 I/O 操作
        - 在数据量大的情况下, 相对于 AOF, RDB 的启动速度更快
    - 缺点
        - 在备份时间点之间的数据容易丢失
        - 使用 fork() 产生子进程进行数据的持久化, 如果数据量很大的话, 会导致 Redis 停止服务几毫秒
    - 手动操作方式
        - SAVE 直接同步形式生成 RDB 快照文件, 过程是阻塞的
        - BGSAVE, 产生子进程的方式来生成 RDB 文件
            - LASTSAVE 查看上一个操作是否成功
- 追加式文件 (AOF文件)
    - 简介: 记录每一个服务器收到的写操作(改, 删)
    - 恢复: 逐条执行, 重建数据
    - 优点
        - 比 RDB 可靠, 默认每秒 fsync 一次, 意味着最多丢失一秒钟的数据
        - AOF 日志是一个纯追加文件, 突然停电或者磁盘满了, 命令只写了一半到日志文件里, 也可以通过用 `redis-check-aof` 这个工具很简单的进行修复
        - 当 AOF 文件过大时, Redis 会在后台进行重写. 重写很安全, 因为是在一个新的文件上进行, 同时会往旧文件追加数据.
        - AOF 是一条条命令保存在文件里的, 很容易导出修改成自己想要的恢复
    - 缺点
        - 同数量下, AOF 文件大小一般比 RDB 大
        - 某些 fsync 策略下, AOF 的速度会比 RDB 慢.
        - 一些罕见的 BUG 导致使用 AOF 重建的数据和原数据不一致的问题
    - 可靠性
        - 每当有新命令追加到 AOF 的时候调用 fsync. 速度最慢, 但是最安全
        - 每秒 fsync 一次. 速度快, 安全性不错
        - 从不 fsync ,交给系统处理, 速度最快, 安全性一般
    - 日志重写
        - Redis 调用 fork(), 产生子进程
        - 子进程把新的 AOF 写到一个临时文件中
        - 主进程持续把变动写到内存里的 Buffer, 同时也会把这些新的变动写到旧的 AOF 中
        - 当子进程完成文件的重写后, 主进程会得到一个信号, 然后将内存里的 Buffer 追加到子进程生成的新 AOF 中
        

### Redis 内存淘汰策略, ttl 指令底层实现

- volatile-lru: 设置了过期时间的数据集中的淘汰最少使用的key
    - 如果希望一些数据能长期被保存，而一些数据可以被淘汰掉时，选择volatile-lru或volatile-random都是比较不错的。
- volatile-ttl: 设置了过期时间的数据集中淘汰 ttl 最大的(将要过期的)
    - 如果研发者需要通过设置不同的ttl来判断数据过期的先后顺序，此时可以选择volatile-ttl策略。
- volatile-random: 从设置过期时间的数据集中随机淘汰
- allkeys-lru: 所有数据中选择最少使用的数据集
    - 在Redis中，数据有一部分访问频率较高，其余部分访问频率较低，或者无法预测数据的使用频率时，设置allkeys-lru是比较合适的。
- allkeys-random: 重数据集中选择任意数据淘汰
    - 如果所有数据访问概率大致相等时，可以选择allkeys-random。
- no-enviction: 禁止数据淘汰, 当内存不足写入数据时会报错

### Redis 主从同步是什么的过程? 新增加从库的步骤?

- 复制过程
    - slave 执行 slaveof 命令
    - slave 只是保存了 slaveof 命令中主节点的信息, 并没有立即发起复制
    - slave 定时任务发现有主节点的信息, 开始使用 socket 连接主节点
    - 连接建立成功后, 发送 ping 命令, 希望得到 pong 命令响应, 否则会进行重连
    - 如果 master 设置了权限, 则进行权限验证, 验证失败复制停止
    - 验证通过后, 进行数据同步, 这是耗时最长的操作, master 将所有数据全部发送给 slave
    - 当 master 把当前的数据同步给从节点后, 便完成了复制的建立流程. 接下来, master 会持续的把写命令发送给 slave, 保证数据一致性
- 同步过程
    - `psync {runId} {offset}` slave 发起同步请求
    - master 根据 runId 和 offset 决定同步策略
        - FULLRESYNC {runId} {offset} 则 slave 触发全量复制流程
            - master bgsave fork 子进程, 生成 RDB 文件
            - master 发送 RDB 到子进程
            - master 在 slave 在接收数据中间, 会将新数据保存一份到 "复制客户端缓冲区", 等 slave 处理完数据后发送过去
            - slave 加载完 RBD 后, 如果开启了 AOF, 会立刻开始写追加文件
        - CONTINUE 触发部分复制 (当网络闪断或其他异常时, 从节点会让主节点补发丢失的命令数据)
            - 当 slave 出现网络中断, 超过了 repl-timeout 时间, 主节点就会中断复制连接
            - master 会将请求的数据写入到 "复制积压缓冲区", 默认 1MB
            - slave 节点恢复后, 重新连接上 master, slave 会发送 offset 和 runId 发送到主节点
            - 主节点校验后, 如果偏移量的数据在缓冲区内, 就发送 continue 响应, 表示可以进行部分复制
            - master 将 cache 中的数据发送到 slave, 保证 master-slave 复制进行正常状态
        - ERR 表明 master 不支持 2.8 的 psync 命令, 将使用 sync 执行全同步
- 异步复制
    - master 接收处理命令
    - master 处理完后返回响应结果
    - 对于修改命令, 异步发送给 slave, slave在主线程执行复制的命令

### Redis 的 zset 怎么实现?

- 实现结构(编码)
    - ziplist (压缩表)
        - 元素将保存到 ziplist 数据结构里, 每个元素以两个 ziplist 节点表示
            - 第一个节点保存元素的 member 域
            - 第二个节点保存元素的 score 域
        - 按照 score 从小到大排序, 如果 score 相同, 那么按字典序对 member 进行对比
        - 查找元素时间复杂度 O(n)
        - 添加删除更新都需要执行一次查找元素的操作, 所以这些函数的复杂度都不低于 O(n)
    - skiplist (跳跃表): 数据结构中同时使用 dict(字典) 和 zskiplist (跳跃表) 来保存 zset 元素
        - 按从小到大的顺序储存分数, 值为 [score, value] 对
        - 元素成员由 redisObject 结构表示, dict, zskiplist 都指向这个对象, 用来节约空间
            - score 是一个 double 类型的浮点数
        - 通过 dict 达到 O(1) 的复杂度查找
        - 通过 zskiplist 
            - 在 O(logN) 期望时间, O(n) 最坏时间内根据 score 对 member 进行定位
            - 范围性查找和处理操作, 这是(高效)实现 `ZRANGE`, `ZRANK` 和 `INSERTSTORE` 等命令的关键
        - 通过同同时使用字典和跳跃表, 有序集可以高效的实现按成员查找和按顺序查找两种操作   
- 结构的选择
    - 在通过 `ZADD` 添加第一个元素到空 key 时, 程序会通过第一个元素来决定创建什么结构
        - ziplist
            - count(zset) < 128 ( `server.zset_max_ziplist_entries` )
            - len(member) < 64 ( `server.zset_max_ziplist_value` )
        - skiplist
            - 以上情况除外则创建 skiplist
- 结构的转换
    - 对于一个 ziplist 结构的 zset, 只要满足以下条件之一, 就会转换为 skiplist
        - count(zset) > 128 || len(member) > 64
- 跳跃表原理 (类似二分查找, 复杂度最佳 O(logN))
    - 每个跳表都必须设定一个最大的连接层数 MaxLevel
    - 第一层连接会连接到表中的每个元素
    - 插入一个元素会随机生成一个连接层数 [1, MaxLevel] 之间, 根据这个值, 跳表会给这个元素建立 N 个连接
    - 插入某个元素的时候, 先从最高层开始, 当跳到比目标值大的元素后, 回退到上一个元素, 用该元素的下一层连接进行遍历, 周而复始知道第一层连接,
    最终在第一层连接中找到合适的位置
- 为什么用跳表不用平衡树
    - (单界好查, 双界难查)需要做范围查找, 在范围查找的时候, 平衡树比 skiplist 操作要复杂. 在平衡树上, 找到指定范围的小值之后, 还需要以中序遍历继续
    寻找其它不大于大值的节点. 而 skiplist 上进行范围查找就非常简单.
    - (插入删除耗时) 平衡树的插入和删除可能引发子树的调整, 逻辑复杂, 而 skiplist 的插入和删除只需要修改相邻节点的指针
    - (更耗内存) 从内存上来说, skiplist 比平衡树更灵活一些. 一般来说, 平衡树每个节点包含两个指针(左右子树), 而 skiplist 每个节点包含的指针数目较低.

### redis key 的过期策略

- 定时过期: 每个设置了过期时间的 key 都创建一个定时器, 到期自动清除
    - 内存友好, CPU 不友好
- 惰性过期: 只有在访问一个 key 时, 才判断 key 是否已经过期
    - CPU 友好, 内存不友好
- 定期过期: 每隔一定时间, 扫描一定数量的设置了过期时间的数据集, 然后清除

### hashmap 是怎么实现的?

- 哈希算法
    - Thomas Wang's 32 bit Mix 函数, 对一个整数进行哈希
    - MurmurHash2
    - djb哈希
- 哈希冲突
    - 链接法, 单向链表, 没有尾指针, 使用头插法将节点添加到链表的表头位置
    - 扩容: 当 hash 表中的元素个数等于一维数组长度时, 就会扩容为原来的2倍
        - 当此时 redis 正在做 bgsave 时, 将会继续增长, 直到负载因子到5时发生强制扩容
    - 缩容: 当元素个数低于数组长度的 10% 时, 将会缩容
- Rehash
    - Dict 中有两个hash表, 目的在于扩容或缩容时的迁移
    

### (2) Redis 哨兵和集群

- 集群的解决方案有三种
    - 主从复制
        - 缺点
            - 无法自动故障修复
            - master 的写能力/储存能力受到单机限制
            - 原生复制, psync 同步不成功则会进行全量同步, 主库在执行全向备份(RBD)时会早场毫秒或者秒级卡顿
        - 作用
            - 备份
            - 分担 master 读压力
    - 哨兵机制: 是一个管理多个 Redis 实例的工具, 可以实现对 Redis 的监控, 通知, 和故障转移
        - 优点: 解决自动故障恢复问题
        - 缺点: 不能解决负载均衡的问题
        - 作用
            - 主节点存活检测
            - 主从运行情况检测
            - 自动故障转移
            - 主从切换
        - 原理
            - 定期执行以下任务
                - 每个 Sentinel 每秒一次向它所知的 master, slave, sentinel 发送 ping 命令
                - 如果一个实例(instance)距离最后一次的有限 pong 时间超过 `down-after-milliseconds` 所指定的值,
                则这个实例会被 sentinel 标记为主观下线
                - 当一个instance被标记为了主观下线, 那么正在监控这个 master 的所有 sentinel 节点都要每秒一次频率确认 master 的确进入了主观下线的状态
                - 如果一个 master 被标记为了主观下线, 并且有足够数量的 sentinel (配置文件配置) 同意这个判断, 那么这个 mgaster 被标记为 客观下线
                - 每个 sentinel 10 秒一次频率向所有已知 master 和 slave 发送 `info` 命令. 当一个 master 被标记为 客观下线时, sentinel 
                向下线 master 和这个 master 下的所有 slave 发送 `info` 的频率提高到每秒一次
                - sentinel 和其它 sentinel 协商主节点的状态, 如果 master 处于 sdown 状态, 则投票自动选出新 master, 
                将其余 slave 指向 master 进行数据复制
    - cluster
        - 优点: 解决负载均衡的问题, 具体方案是分片/虚拟槽 slot
        - 缺点: 没有达到强一致
        - 作用: 高并发, 解决单机容量有限的问题
        - 原理: 使用数据分片(sharding)来实现
            - 一个集群包含 16384 个哈希槽 (hash slot)
            - 使用公式 CRC16(key) % 16384 来计算 key 在哪个槽上
            - 每个节点负责处理啦一部分哈希槽
                - 这些节点还可以有从节点, 使用主从复制模型
                - 当主节点下线时, 从节点可以代替主节点来执行任务处理槽
            - 主节点处理槽
            - 从节点用于复制某个主节点, 并在被复制的主节点下线时, 代替下线的主节点继续处理命令请求.
            - 新加入节点时, 会将原来的节点中的一部分槽移动到新节点中

### (4) Redis 底层数据结构

- Dict
    - 哈希表实现
    - 结构
        - dict 字典结构
            - type
            - privdata
            - ht[2] 哈希表, 两个哈希表主要为了扩容或缩容使用
            - rehashidx rehash 索引, 当 rehash 不再进行时, 值为 -1
            - iterators 迭代器数量
        - dictht 哈希表
            - dictEntry **table  哈希节点数组
            - size 哈希表大小
            - sizemask 哈希表大小掩码, 用于计算索引值, 等于 size - 1
            - used 已有节点数量
        - dictEntry 哈希节点
            - key
            - v
            - next 指向下一哈希表节点, 形成链表
    - 特点
        - rehash: 当链表需要扩容或缩容时, 通过 ht[2] 这两个 hash 表进行
- SDS 简单动态字符串
    - 结构
        - len 已使用字节长度
        - free 未使用的字节数量
        - buf[] 保存字节数组
    - 特点
        - O(1) 获取字符串长度
        - 修改字符串 N次 最多需要 N次 内存重新分配 , 使用 空间预分配和惰性空间释放
        - 二进制安全 (\0 结尾的问题) 
- 链表
    - 双向链表, 保存头尾, 无环, 链表计数器, 多态(value储存多种结构)
    - 结构
        - list
            - listNode *head
            - listNode *tail
            - len
        - listNode
            - prev
            - next
            - value 可以储存多种结构
- 跳跃表
    - 可以理解为多层的链表
        - 多层的组成结构, 每层是一个有序的链表
        - 最底层(level 1)的链表包含所有的元素
        - 跳跃表的查找次数近似于层数, 时间复杂度 O(logN), 插入删除也为 O(logN)
        - 跳跃表是一种随机化的数据结构(通过抛硬币来决定层数)
    - 结构
        - zskiplist
            - zskiplistNode *head, *tail
                - sds ele 成员对象, 唯一
                - score 分值
                - skiplistNode *backward 后退指针
                - zskiplistLevel level[]
                    - zskiplistNode *forward 前进指针
                    - span 跨度: 用来计算元素排名(rank)的
            - length
            - level
- 整数
    - 是 set 的底层实现之一, 如果一个 set 只包含整数元素, 且元素不多时, 会使用整数集合作为底层实现
    - 可以保存 int16_t, int32_t, int64_t
    - 结构
        - intset
            - encoding: contents 数组的真正来兴
                - INTSET_ENC_INT16
                - INTSET_ENC_INT32
                - INTSET_ENC_INT64
            - length: 整数集合的元素数量, 即 contents[] 数组长度
            - contents[]: 集合中的每个元素按照值的大小从小到大排序, 且不包含重复项
    - 升级
        - 当想要添加一个新元素到整数集合中时, 并且当新元素的类型比整数集合现有的所有元素的类型都要长, 整数集合需要先进行升级
        - 过程
            - 根据新元素类型, 扩展整数集合底层数组的空间大小, 并为新元素分配空间
            - 把数组现有的元素都转换成新元素的类型, 并将转换后的元素放到正确的位置, 且要保持数据的有序性
            - 添加新元素到底层数组
        - 不支持降级
- 压缩列表 ziplist
    - 是为了节约内存设计的, 是由一系列特殊编码的连续内存块组成的顺序性(sequential)数据结构, 一个压缩列表可以包含多个节点, 每个节点可以保存一个字节数组或者一个整数值
    - 压缩列表是 列表(list) 和散列(Hash)的底层实现之一, 一个列表只包含少量列表项, 并且每个列表项, 是小整数或比较短的字符串, 
    会使用压缩列表作为底层实现(3.2版本之后用 quicklist 实现)
    - 组成
        - zlbytes: 记录整个压缩列表占用的内存字节数, 在压缩列表内存重新分别, 或者计算 zlend 的位置时使用
        - zltail: 记录压缩列表表尾距离压缩列表起始地址有度搜好字节, 通过该偏移量, 可以不遍历整个压缩列表就可以获取到表尾地址
        - zllen: 记录列表包含的节点数量, 小于 UIN16_MAX(65535)时才有效, 否得得遍历计算节点数量
        - entryX: 压缩列表的节点
        - zlend: 特殊值 0xFF (十进制255), 用于标记压缩列表的末端
        - entry 节点
            - previous_entry_length: 记录压缩列表前一个字节的长度
            - encoding: 节点的content的内容类型
            - content: 保存节点内容
- 对象: 使用以上数据结构形成了对象系统, 成为 Redis 里能够操作的对象
    - REDIS_STRING
        - REDIS_ENCODING_INT int
            - 使用整数值实现的字符串对象
        - REDIS_ENCODING_EMBSTR embstr
            - 使用 embstr 编码的简单动态字符串实现的字符串对象
        - REDIS_ENCODING_RAW raw
            - 使用简单动态字符串实现的字符串对象
    - REDIS_LIST
        - REDIS_ENCODING_ZIPLIST ziplist
            - 使用压缩列表实现的列表对象
        - REDIS_ENCODING_LINKDLIST linkedlist
            - 使用双端列表实现的列表对象
    - REDIS_HASH
        - REDIS_ENCODING_ZIPLIST ziplist
            - 使用压缩列表实现的哈希对象
        - REDIS_ENCODING_HT hashtable
            - 使用字典实现的哈希对象
    - REDIS_SET
        - REDIS_ENCODING_INTSET intset
            - 使用整数集合实现的集合对象
        - REDIS_ENCODING_HT hashtable
            - 使用字典实现的集合对象
    - REDIS_ZSET
        - REDIS_ENCODING_ZIPLIST ziplist
            - 压缩列表实现的有序集合对象
        - REDIS_ENCODING_SKIPLIST skiplist
            - 使用跳跃表实现的有序集合对象
            

### (4) Redis 数据类型对应命令

- String: 字符串
    - 命令
        - set
            - 设置 value, 配合 ex/px 参数指定有效期, nx/xx 参数针对key是否存在的情况进行区别操作
            - O(1)
        - get
            - O(1)
            - 对 key 设置 value, 并返回该 key 原来的 value
        - getset
            - O(1)
        - mset
            - 为多个 key 设置 value
            - O(m)
        - msetnx
            - 同 mset, 当指定 key 中有任意一个已存在, 则不进行任何操作
            - O(m)
        - mget
            - O(m)
        - incr, decr 
            - O(1)
        - incrby, decrby
            - O(1)
- Hash: 哈希列表
    - 命令
        - hset
            - 将 key 对应的 Hash 中的 field 设置为 value
            - O(1)
        - hget
            - O(1)
        - hmset, hmget
            - 设置/获取多个 field
            - O(m) m 为操作的 field 个数
        - hsetnx
            - 当 field 已经存在时不会进行操作
            - O(1)
        - hdel
            - 删除 field
            - O(1)
        - hincrby
            - O(1)
        - hgetall
            - 获取所有 field, 返回数组
            - O(n)
        - hkeys/hvals
            - 返回所有 field/value
            - O(n)
- List: 列表
    - 命令
        - lpush, rpush
            - 向左侧插入一个或者多个元素, 返回长度
            - O(m) 插入元素数量
        - lpop, rpop
            - 弹出一个元素并返回
            - O(1)
        - lpushx, rpushx
            -  当 key 存在时才操作
            - O(m)
        - llen
            - O(1)
        - lrange
            - 获取范围内的元素
            - O(n)
        - lindex
            - 返回指定 index 的元素
            - O(n)
        - lset
            - 指定 index 设置 value
            - O(n)
        - linsert
            - 向指定元素前/后插入一个新元素
            - O(n)
- Set: 集合
    - 命令
        - sadd
            - 添加若干个 member
            - O(m)
        - hrem
            - 移除一个或多个 member
            - O(m)
        - srandmember
            - 从 set 中随机返回1个或多个 member
            - O(m)
        - spop
            - 从 set 中随机移除并返回 count 个 member
            - O(m)
        - scard
            - 返回数量
            - O(1)
        - sismember
            - 判断指定 value 是否存在于 set 中
            - O(1)
        - smove
            - 将指定的 member 从一个 set 移至 另一个 set 中
            - O(1)
        - smembers
            - 返回所有 member
            - O(n)
        - sunion/sunionstore
            - 计算多个 set 的并集并返回/储存到另一个set中
            - O(n)
        - sinter/sinterstore
            - 计算多个 set 交集并返回/储存到另一个set中
            - O(n)
        - sdiff/sdiffstore
            - 计算 1 个 set 与 1或多个 set 的差集并返回/储存至另一个 set 中
            - O(n)
- Sort Set: 有序集合
    - 命令
        - zadd
            - O(m)
        - zrem
            - O(m)
        - zcount
            - 返回 zset 中指定 score 范围内的 member 数量
            - O(logN)
        - zcard
            - 返回 zset 中 member 数量
            - O(1)
        - zscore
            - 返回 zset 中指定 member 的 score
            - O(1)
        - zrank/zrevrank
            - 返回指定 member 在 zset 中的排名, 升序/降序
            - O(log(N))
        - zincrby
            - 对 zset 中指定 member 的 score 进行自增
            - O(logN)
        - zrange/zrevrange
            - 返回指定排名范围的所有 member , 升序/降序
            - O(log(N) + M), M 是返回的 member 数.
        - zrangebyscore/zrevrangebyscore
            - 返回指定 score 范围内所有的 member , 升序/降序
            - O(log(N) + M), M 为返回的 member 数量
        - zremrangebyrank/zremrangebyscore
            - 移除指定排名范围/指定 score 范围内的所有 member
            - O(log(N) + M)
- Bitmaps: 位图, 在 string 的基础上进行位运算操作,可以实现节省空间的数据结构
- Hyperloglog: 用于估计一个 set 中元素数量的概率的数据结构
- Geo: geospatial, 地理空间索引半径查询
- BloomFilter: 布隆过滤器

- 通用命令
    - Redis 数据库整个就是 dict 实现的, 所以对于单个 key 的操作, 一般都是 O(1) 复杂度
    - keys
        - 列出所有的 key
        - O(n)
    - exists
        - 判断一个或者多个 key 是否存在
        - O(n)
    - del
        - 删除一个或多个 key
        - O(1)
    - expire, pexpire
        - expire 设置 key 在多少秒后过期, pexpire 设置在多少毫秒后过期
        - O(1)
    - ttl, pttl
        - 获取 key 的过期时间
        - O(1)
    - expireat, pexpireat
        - 设置 key 的到期时间戳
        - O(1) 
    - persist
        - 将 key 设置为永久有效
        - O(1)
    - rename/renamenx
        - O(1)
    - type
        - O(1)
    - config get
        - O(1)
    - config set
        - O(1)
    - config rewrite
        - 重新加载 redis.conf 中的配置

### Redis 如何实现高可用?

- 哨兵模式
- 集群

### zset 延时队列怎么实现的

zset 天然有序, 使用 score 来储存时间戳, 设置定时器定时查询 zset (zrangebyscore), 获取到可以执行的元素, 然后执行

可以通过 zrem 命令来保证获取的原子性

### zset做排行榜时,  如果要实现相同分数时按照时间顺序排序怎么实现?

在分数上加入时间戳, 计算公式为: `带时间戳的分数 = 实际分数 * 10000000000 + (9999999999 - timestamp)`

这个思路是使用 分数位+ (9999999999 - 10位时间戳)

### (3) redis单线程多线程? 原因? 如何实现高效?

- 基于内存的, 内存读写非常快
- 单线程的, 省去了很多上下文切换线程的时间
- 使用多路复用技术, 可以处理并发的连接. 内部使用 epoll 实现非阻塞 IO. 采用 epoll + 自己实现的简单的时间框架.
epoll 中的 读/写/关闭/连接 都转化为了事件, 然后利用 epoll 多路复用的特性, 绝不在 IO 上浪费一点时间.

### redis能否当消息队列? 用过哪些中间件消息队列? 有什么不同?

Redis 消息推送 （基于 pub/sub）并不可靠, 断电就丢失

Redis list 有持久化, 但是功能太少, 也不完全可靠, 没有消息确认机制

RabbitMQ 有持久化, 有确认机制, 可以保证消息的生产和消费, 支持事务, 支持交换机, 路由键, 等功能, 有管理界面, 支持主从

### redis 订阅发布功能

Redis 通过 publish, subscribe 等命令实现订阅与发布模式, 分为两种通信机制

- 频道
    - 频道的订阅与消息发送
        - `subscribe` 订阅任意数量的频道, 每当频道收到信息, 就会发布给所有订阅了频道的客户端
    - 发送信息到频道
        - `publish`
    - 退订频道
        - `unsubscrbe`
    - 原理
        - redisServer
            - dict *pubsub_channels 字典中的节点表示通道, 通道连接着订阅了这个频道的所有客户端 
- 模式
    - 模式的订阅与信息发送
        - 订阅模式, 按照匹配来接收消息
    - 订阅模式
        - `psubscribe`
    - 发送信息到模式
        - `publish`
    - 退订模式
        - `punsubscribe`
    - 原理
        - redisServer
            - list *pubsub_patterns
                - 链表节点
                    - redisClient *client 保存订阅的客户端
                    - robj *pattern 被订阅的模式

### 2核CPU4G内存使用Redis最大QPS是多少?

可以利用 Redis 单线程的特性, 启动两个 Redis 实例, 一般一个 Redis 实例的 QPS 在几万左右, 双实例大概可以翻倍.

### Redis连接时的connect与pconnect的区别

connect 在脚本结束后就会释放连接

pconnect 在脚本结束后会被脚本的管理程序(php-fpm)储存起来, 再连接时会直接用, 可以减少连接次数

### Redis key和value的大小限制

均为 512M

### setnx 分布式锁实现

> 什么是分布式锁

    分布式锁是控制分布式系统或不同系统之间共同访问共享资源的一种锁表现

#### 分布式锁条件

- 互斥性: 在任意一个时刻, 只有一个客户端持有锁
- 无死锁: 即便持有锁的客户端崩溃或者其它意外事件, 锁仍然可以被获取
- 容错: 只要大部分 Redis 节点都活着, 客户端就可以获取和释放锁

#### 分布式锁的主要实现

- 数据库
- Memcached (add命令)
- Redis (setnx命令)
- Zookeeper (临时节点)

#### 单机 Redis 分布式锁

- 加锁: `set key value [EX seconds] [px milliseconds] [NX|XX]`, value 需要保证唯一
- 释放锁: 解锁时, 需要判断锁是否是自己的, 基于value值来判断. 通常使用 lua 脚本来判断
    - `if redis.call('get',KEYS[1]) == ARGV[1] then return redis.call('del',KEYS[1]) else return 0 end`
- 解决的问题
    - 锁超时问题, 超时后锁会自己释放
    - 释放了别人的锁的问题: 客户端A获取到锁后执行, 阻塞超时到锁解锁了, 后面B客户端拿到了锁, A阻塞执行完了, 执行释放锁就把B客户端的锁释放了,
    所以释放时需要判断 value 是否是自己设置的.

### Redis 各种类型的使用场景
### 缓存的热点 Key 怎么处理?
### Redis 缓存穿透, 怎么避免?
### redis keys 命令有什么缺点?
### 如果redis作为分布式锁的时候，主节点挂掉了，但是数据还没有同步到从节点，这种情况怎么办？
### 解决缓存击穿的方式有哪几种?加锁的时候什么时候选择本地锁，什么时候选择分布式锁?
### Redis 4.0 有什么新特性
### redis的lru策略
### lru是如何移除和插入数据的？链表中存储的是什么数据，如果没有索引那还存储什么？
### Redis 数据备份和恢复有哪些
### 两种备份方式有什么优缺点
### Redis 出了问题解决步骤
### sds 的结构是什么？为什么要存长度？跟 c 里的字符串有什么区别？（关键词：获取长度复杂度 O (1) 和 O (n)，二进制安全，保存 \0，跟 C 库字符串函数可以通用）
### hash 怎么实现的？怎么解决 hash 冲突？除了 hashTable 还有别的吗？
### rehash 过程？会主动 rehash 吗？
### 用 redis 可以实现队列吗？有什么优点和缺点？
### 用 redis 怎么实现一个延时队列？
### rdb 和 aof 过程？rdb 为什么可以用创建子进程的方式进行？（这里考察一个 cow）这两种持久化方式会丢数据吗？
### 一致性哈希是什么？节点较少时数据分布不均匀怎么办？
### lua 脚本的作用是什么？