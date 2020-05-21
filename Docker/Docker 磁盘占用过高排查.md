# Docker 磁盘占用过高排查

磁盘文件在 `/var/lib/docker/overlay2/` 目录下

## 命令

查看 docker 磁盘占用情况: `docker system df`

查看是否有死掉没有删除的日志: `docker ps -a`

清理悬空镜像, 不会删除未使用的镜像 `docker system prune`

删除以下内容: `docker system prune -a`
已停止的容器（container）
未被任何容器所使用的卷（volume）
未被任何容器所关联的网络（network）
所有悬空镜像（image）

