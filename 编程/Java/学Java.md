# 学Java

## 名词

- JDK: `Java Development Kit` Java开发环境，包含运行Java字节码的虚拟机、编译器、调试工具等
- JRE: `Java Runtime Environment` Java运行环境

## Java 安装目录 /bin 下的文件作用

- `java`: JVM，用来运行Java程序
- `javac`: java的编译器，将 `.java` 源文件编译成 `.class` 字节码文件
- `jar`: 把一组`.class`打包成一个 `.jar`文件，便于发布。
- `javadoc`: 用于从Java源码中自动提取注释并生成文档
- `jdb`: Java调试器，用于开发阶段的开发调试。

## 安装

### Ubuntu

官网下载地址: `https://www.oracle.com/technetwork/java/javase/downloads/jdk13-downloads-5672538.html`

选中 `jdk-13.0.01_linux-x64_bin.deb` 下载然后安装。

默认安装目录为: `/usr/lib/jvm/jdk-13.0.1`，添加到 PATH 中。

查看`Java`版本: `java --version`

## 报错解决

- `maven compile 不再支持源选项 5。请使用 7 或更高版本。`

在`pom.xml`中增加: 

```xml
    <properties>
        <project.build.sourceEncoding>UTF-8</project.build.sourceEncoding>
        <maven.compiler.encoding>UTF-8</maven.compiler.encoding>
        <java.version>13</java.version>
        <maven.compiler.source>13</maven.compiler.source>
        <maven.compiler.target>13</maven.compiler.target>
    </properties>
```

## Maven

### Maven 生命周期

- validate 验证项目及构建信息是否可用
- compile 编译项目源代码
- test 使用单元测试框架运行测试用例
- package 将编译代码打包 jar/war 等
- install 发布到本地仓库
- deploy 发布到远程仓库

### 设置阿里云源加速

编辑`vim ~/.m2/settings.xml`加入以下内容  

```xml
<settings xmlns="http://maven.apache.org/SETTINGS/1.0.0"
      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:schemaLocation="http://maven.apache.org/SETTINGS/1.0.0
                          https://maven.apache.org/xsd/settings-1.0.0.xsd">

      <mirrors>
        <mirror>  
            <id>alimaven</id>  
            <name>aliyun maven</name>  
            <url>http://maven.aliyun.com/nexus/content/groups/public/</url>  
            <mirrorOf>central</mirrorOf>          
        </mirror>  
      </mirrors>
</settings>
```

### 设置允许使用快照版本的库

`vim ~/.m2/settings.xml`, 写入以下内容

```xml
<settings xmlns="http://maven.apache.org/SETTINGS/1.0.0" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://maven.apache.org/SETTINGS/1.0.0
                          https://maven.apache.org/xsd/settings-1.0.0.xsd">

  <mirrors>
    <mirror>
      <id>alimaven</id>
      <name>aliyun maven</name>
      <url>http://maven.aliyun.com/nexus/content/groups/public/</url>
      <mirrorOf>central</mirrorOf>
    </mirror>
  </mirrors>
  <profiles>
    <profile>
     <id>allow-snapshots</id>
     <activation><activeByDefault>true</activeByDefault></activation>
     <repositories>
       <repository>
         <id>snapshots-repo</id>
         <url>https://oss.sonatype.org/content/repositories/snapshots</url>
         <releases><enabled>false</enabled></releases>
         <snapshots><enabled>true</enabled></snapshots>
       </repository>
     </repositories>
   </profile>
  </profiles>
</settings>
```

idea 中始终更新快照版本 `Preferences->Build->Build Tools->Maven->Always update snapshots`
