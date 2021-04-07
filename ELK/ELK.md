# ELK

## 描述

通常用作分布式日志搜索引擎, 通常包含以下组件

FileBate
消息队列(Redis)
Logstash
ElasticSearch
Kibana

## hbase

开源非关系型分布式数据库, 使用 Java 实现, 运行于 HDFS 文件系统上.

优势: 提供了高并发的随机写和支持实时查询，这是HDFS不具备的。

对比 MongoDB:

- Hbase 是列储存(适用于数据压缩, 对指定几个字段进行查询效率很高), MongoDB 是文档储存 (用类似 json 格式进行储存)
- Hbase 适用于简单数据存储, 海量,结构简单数据查询
- MongoDB 支持复杂查询
- Hbase 基于 HDFS (分布式文件储存系统), 对于分布式数据储存有优势

对比 Redis:

- Redis 支持的数据类型更多
- HBase 只支持简单的字符串

场景:

储存 SMS 发送记录
储存 IM 系统记录


## elasticsearch


