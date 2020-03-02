# rabbitmq 操作命令

## 增加一个用户对一个 vhost 的权限

`sudo rabbitmqctl set_permissions -p vhostname username '.*' '.*' '.*'`

## 查看用户在 vhost 中的权限

`sudo rabbitmqctl list_permissions --vhost fuwu-openapi`

## 修改密码

> 查看用户列表

`rabbitmqctl list_users`

> 修改用户

`rabbitmqctl change_password Username 'Newpassword'`
