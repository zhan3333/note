# ssh 执行命令

```shell
ssh name@host "ls"
```

执行多个命令，用 `<<标识` 来扩起命令

```shell
#!/bin/bash
ssh -tt user@remoteNode > /dev/null 2>&1 << eeooff
cd /home
touch abcdefg.txt
exit
eeooff
echo done!
```