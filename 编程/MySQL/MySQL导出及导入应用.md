# MySQL导出及导入应用

## 导出

导出使用`mysqldump`工具

导出到当前目录中

```shell
mysqldump -u root -p123456 --databases {you_database} --tables  > you_database.sql
```

参数说明

- `--databases {database_name}` 指定导出的数据库
- `--tables {table_name}` 指定导出的表，增加此选项后，将不会在导出的SQL中产生`create {database_name}` 这样的语句，便于在数据库导入时指定不同的数据库名称

## 导入

### 方式1: 通过`<`方式导入

```shell
mysql -u root -p123456 --database={name} < {you_backup_database.sql}
```

### 方式2: 通过`source`命令导入

```shell
mysql> create database {you_database}
mysql> use {you_database}
mysql> source /home/user/backup/you_backup_database.sql
```
