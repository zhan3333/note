# rabbitmq 操作命令

## 增加一个用户对一个vhost的权限

`sudo rabbitmqctl set_permissions -p vhostname username '.*' '.*' '.*'`

## 查看用户在vhost中的权限

`sudo rabbitmqctl list_permissions --vhost fuwu-openapi`
