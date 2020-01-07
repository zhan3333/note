# MySQL 连接数

查看最大连接数

```sql
show variables like '%max_connections%';
```

设置最大连接数

```sql
set global max_connections=1000
```

查看打开的连接数

```sql
show status like 'Threads%';
```

Threads_connected: 指打开的连接数
Threads_running: 指激活的连接数

查看数据库连接超时时间

```sql
show variables like "%timeout%"
```

or

```sql
show global variables like '%wait_timeout';    --可以查看数据库空闲等待时间，默认8小时，最大2147483，接近24天
```

wait_timeout 选项指默认连接经过 8 小时没有向服务器发送请求时, 它就会断开这个连接
