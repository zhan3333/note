# maven发布到仓库

## macos 安装 maven

1. 打开Maven官网下载页面：maven.apache.org/download.cg…
下载:apache-maven-3.5.0-bin.tar.gz

2. 解压下载的安装包到某一目录，比如：/Users/xxx/Documents/maven

3. 加入路径到 ~/.zshrc 中

## 遇到的问题

上传jar到中央仓库的时候报错: `gpg: signing failed: Inappropriate ioctl for device`

原因是 gpg 在当前的终端无法弹出密码输入页面

解决方式:

```shell
export GPG_TTY=$(tty)
```

## maven 查看当前生效的 settings.xml

```shell
mvn help:effective-settings
```
