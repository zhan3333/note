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

## mac 下开机启动

`sudo /Library/LaunchDaemons/com.supervisor.start.plist`

```xml
<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE plist PUBLIC "-//Apple//DTD PLIST 1.0//EN" "http://www.apple.com/DTDs/PropertyList-1.0.dtd">
<plist version="1.0">
<dict>
    <key>KeepAlive</key>
    <dict>
        <key>SuccessfulExit</key>
        <false/>
    </dict>
    <key>Label</key>
    <string>com.supervisor.start</string>
    <key>ProgramArguments</key>
    <array>
        <string>/usr/local/bin/supervisord</string>
        <string>-n</string>
        <string>-c</string>
        <string>/etc/supervisord.conf</string>
    </array>
    <key>RunAtLoad</key>
    <true/>
</dict>
</plist>
```

`sudo launchctl load /Library/LaunchDaemons/com.supervisor.start.plist`

查看是否加载成功: `sudo launchctl list | grep supervisor`
