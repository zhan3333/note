# CentOS 安装node环境

## 安装

### yum 安装 

该安装方法安装的版本一般非常的旧

1. 安装EPEL 仓库 `yum install epel-release`
2. 安装 nodejs: `yum install nodejs`
3. 安装 npm: `yum install npm`

### 下载安装

1. 在`https://nodejs.org/en/download/`上复制 `Linux Binaries(x64) ` 链接
2. `wget https://nodejs.org/dist/v12.13.1/node-v12.13.1-linux-x64.tar.xz`
3. `tar -xvf node-v12.13.1-linux-x64.tar.xz`
4. `cp -r node-v12.13.1-linux-x64 /usr/local/node`
5. `ln -s /usr/local/node/bin/node /usr/local/bin/node`
6. `ln -s /usr/local/node/bin/npm /usr/local/bin/npm`

这种安装方法需要使用root安装，并且需要设置相应的权限

## 更新

`npm install -g npm`