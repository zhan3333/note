# maven 发布到仓库

## macos 安装 maven

1. 打开 Maven 官网下载页面：maven.apache.org/download.cg…
   下载:apache-maven-3.5.0-bin.tar.gz

2. 解压下载的安装包到某一目录，比如：/Users/xxx/Documents/maven

3. 加入路径到 ~/.zshrc 中

## 遇到的问题

上传 jar 到中央仓库的时候报错: `gpg: signing failed: Inappropriate ioctl for device`

原因是 gpg 在当前的终端无法弹出密码输入页面

解决方式:

```shell
export GPG_TTY=$(tty)
```

## maven 查看当前生效的 settings.xml

```shell
mvn help:effective-settings
```

## maven 执行命令时跳过测试

```shell
mvn package -Dmaven.test.skip=true
```

或者在 pem 中修改

```shell

<plugin>
    <groupId>org.apache.maven.plugin</groupId>
    <artifactId>maven-compiler-plugin</artifactId>
    <version>2.1</version>
    <configuration>
        <skip>true</skip>
    </configuration>
</plugin>
<plugin>
    <groupId>org.apache.maven.plugins</groupId>
    <artifactId>maven-surefire-plugin</artifactId>
    <version>2.5</version>
    <configuration>
        <skip>true</skip>
    </configuration>
```
