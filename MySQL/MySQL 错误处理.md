# MySQL 错误处理

## MySQL: ERROR 1040: Too many connections

查看连接上限

```mysql
show variables like "max_connections";
```

修改连接上限

```mysql
set global max_connections = 200;
```

## on dulicate key update deadlock bug 

https://mingwho.com/posts/insert-on-duplicate/

主要是 next-key 导致的死锁，最好改为 insert 调用。