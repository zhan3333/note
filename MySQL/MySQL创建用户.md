# MySQL 创建用户

## 创建用户

只创建用户

```sql
create user test identified by 'test@test';
```

创建用户并授予 dbName 库所有权限

```sql
create user test identified by 'test';
grant all privileges on dbName.* to zhangsan@'%';
flush  privileges;
```

## 设置权限

```sql
grant select on dbName.* to test@'%';
```

可以设置的权限有

- all privileges
- select
- delete
- update
- create
- drop

可以选择的库或者表

- . : 所有库的所有表
- dbName.\* : dbName 库的所有表
- dbName.tableName : dbName 库的 tableName 表

user@host 表示授予的用户以及允许该用户登录的 IP 地址:

- localhost 只允许本地登录,不允许远程登录
- % 允许在除本机之外的任何一台机器远程登录
- 192.168.50.200 只允许这个 IP 登录

## 修改密码

8.0 之前

```sql
update mysql.user set password = password('test') where user = 'test' and host = '%';
flush privileges;
```

8.0 之后

```shell
use mysql;
alter USER 'root'@'localhost' IDENTIFIED BY 'nwe_password';
update user set host = "%" where user='root'; // 修改远程连接密码
update user set host = "localhost" where user='root'; // 修改本地连接密码
# 刷新权限
flush privileges;
```

## 删除用户

```sql
drop user zhangsan@'%';
```

##
