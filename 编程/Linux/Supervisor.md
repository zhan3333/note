# Supervisor

## group

group 可以将进程成组管理

```
[group:laravel]
programs=laravel

[program:laravel]
command=docker exec -i --user zhan php bash -c 'cd /work/skysharing/cass/api; php artisan swoole:http start'
autostart=true
autorestart=true
user=zhan
numprocs=1
startretries=3
stopasgroup=true
killasgroup=true
stdout_logfile=stdout.log
stderr_logfile=stderr.log
```

## 允许非root用户重启某些进程

使用  sudoer 来配置非root用户能够sudo执行的命令

编辑 `etc/sudoers` 文件，加入以下内容

```vim
www ALL = (root) NOPASSWD:/usr/bin/supervisorctl restart laravel-worker
```

以上命令允许 `www` 用户直接运行 `/usr/bin/supervisorctl restart laravel-worker` 命令而不需要root密码与权限