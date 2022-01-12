# 查看所有用户的crontab

有些时候需要查看所有用户设定的crontab配置来排查问题，用root身份执行以下命令即可。

```shell
for user in $(cut -f1 -d: /etc/passwd); do echo $user; crontab -u $user -l; done
```
