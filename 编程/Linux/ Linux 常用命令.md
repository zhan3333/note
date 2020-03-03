# Linux 常用命令

## 端口相关

### 查看使用端口的进程 pid

```shell
lsof -i:8888
```

### 根据 pid 杀进程

```shell
kill -s 9 15555
```
