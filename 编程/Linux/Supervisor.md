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