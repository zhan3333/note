# Ubuntu 安装 node 开发环境

1. 访问 `https://nodejs.org/en/download/` 页面
2. 选中 `Installing Node.js via package manager`
3. 找到相应的Linux发行版本进行安装

## 配置npm路径

1. ~/.npm 下新建 `node_modules`, `node_cache` 两个文件夹

```shell
mkdir ~/.npm/node_modules
mkdir ~/.npm/node_cache
```

2. 设置npm

```shell
npm config set prefix ~/.npm/node_modules
npm config set prefix ~/.npm/node_cache
```

3. 加入 bin 到环境变量中
