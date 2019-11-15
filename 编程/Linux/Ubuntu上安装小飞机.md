# Ubuntu 安装小飞机


安装最新版本的 shadowsocks，旧版本可能会出现 `aes-255-gcm`找不到的问题
```shell
sudo pip install https://github.com/shadowsocks/shadowsocks/archive/master.zip
```

## 生成pac文件

- 安装 `pacgen`: `sudo pip install -U genpac`
- 生成`pac`: `enpac --proxy="SOCKS5 127.0.0.1:1090" --gfwlist-proxy="SOCKS5 127.0.0.1:1090" -o autoproxy.pac --gfwlist-url="https://raw.githubusercontent.com/gfwlist/gfwlist/master/gfwlist.txt"`