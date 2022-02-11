# MSI 360M 微星主板黑苹果过程

## 参考

[EFI 下载](https://github.com/SuperNG6/MSI-B360-Big-Sur-EFI)

[安装教程](https://sleele.com/2019/07/14/gettingstartedtutorial/)

## 准备工作

- U盘 >= 16G

## 过程

1. 下载 MacOS 镜像

https://blog.daliansky.net/macOS-Mojave-10.14.5-18F132-official-version-with-Clover-4928-original-image.html

在黑果小兵的博客中，找到 EFI 允许版本的 MacOS 镜像。镜像自带什么 EFI 不重要，会被 github 上的 EFI 替换。

2. 用 Etcher 将下载好的镜像写入到 U盘中

https://www.balena.io/etcher/

3. Clover Configurator 加载 U盘 中的 EFI 分区

用 github 上下载的 EFI 替换 U盘中的 EFI 分区的 EFI 文件夹

4. U盘插入待安装主机，重启电脑从 U盘启动

5. 选择 Install MacOS 启动

启动后开始了安装过程，会有个苹果的大 logo 和进度条，中间会重启两到三次，每次重启需要选择从 U盘启动。

如果错过了可以手动重启再选择 U盘启动

6. 安装完毕

进入系统，下载 Clover Configurator, 加载 U盘 EFI 和 系统 EFI。

使用 U盘 EFI 替换系统 EFI，替换完后可以弹出 U盘不需要再使用了。

电脑重启选择从 Mac 盘启动即可进入 MacOS。