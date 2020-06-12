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

### 查看文件夹大小

`du -hs *`

### 查看文件大小排行

```shell script
du -hs * | sort -hr

# 选出排在前面的10个
du -sh * | sort -hr | head 

# 选出排在后面的10个
du -sh * | sort -hr| tail 
```