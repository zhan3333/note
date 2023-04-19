# docker-compose 常用命令

https://yeasy.gitbook.io/docker_practice/compose/commands

创建并启动所有容器 `docker-compose up -d`, 默认会停止所有容器，然后重新创建。
`--no-recreate` 只启动处于停止状态的容器，忽略已经运行的容器。
`--no-deps` 只重新创建启动指定的服务，不影响其他服务。

停止所有容器 `docker-compose down`
验证 compose 配置文件是否征程 `docker-compose config`
打印某个容器端口所映射的公共端口: `docker-compose port [options] SERVICE PRIVATE_PORT`

## 常见问题

services 之间无法通过 service_name 通信:  attachable 配置在 v3 默认为 false, 需要单独配置为 true。

https://docs.docker.com/compose/networking/