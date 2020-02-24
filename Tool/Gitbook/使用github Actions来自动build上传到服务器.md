# 使用github Actions来自动build上传到服务器

## 需要在项目的 `Settings->Secrets` 配置如下几项:

- scp
  - HOST 你的主机地址
  - USERNAME 登录你的主机用的用户名
  - DIR 主机上的保存编译后文件的路径
  - KEY scp访问私钥

## 配置如下

```yml
name: CI

on: [push]

jobs:
  build:

    runs-on: ubuntu-latest

    steps:

      - name: Check out source code
        uses: actions/checkout@v1

      - name: Setup Node.js for use with actions
        uses: actions/setup-node@v1.1.0

      - name: install
        run: |
          npm install -g gitbook-cli
          gitbook install
          gitbook build

      - name: copy dir to remote server
        uses: appleboy/scp-action@master
        with:
          host: ${{ secrets.HOST }}
          username: ${{ secrets.USERNAME }}
          source: "_book"
          target: ${{secrets.DIR}}
          key: ${{secrets.KEY}}
          rm: true
```
