# NPM 换源

## 使用阿里云镜像

1. 临时使用
npm --registry https://registry.npm.taobao.org install express

2. 持久使用
npm config set registry https://registry.npm.taobao.org

3. 通过cnpm
npm install -g cnpm --registry=https://registry.npm.taobao.org

## 使用官方镜像

npm config set registry https://registry.npmjs.org/

## 查看npm源地址

npm config get registry
