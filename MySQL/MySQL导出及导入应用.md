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

### 一个脚本执行备份

```bash
#!/bin/bash
#数据库的定时备份
#定义备份的路径
BACKUP=/var/mysql/backup
DATETIME=`date +%Y_%m_%d_%H%M%S`
#echo "$DATETIME"
#主机
DB_USER=root
DB_PWD=123456
DATABASE=test

echo "=====start backup to $BACKUP/$DATABASE/$DATABASE_$DATETIME.sql======"
[ ! -d "$BACKUP/$DATABASE" ] && mkdir -p "$BACKUP/$DATABASE"
docker exec -it mysql mysqldump -u${DB_USER} -p${DB_PWD} --databases $DATABASE --tables > $BACKUP/$DATABASE/$DATABASE_$DATETIME.sql
find $BACKUP/$DATABASE -mtime +10 -name "*.sql" -exec rm rf {} \;
echo "===========backup success======"
```

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
