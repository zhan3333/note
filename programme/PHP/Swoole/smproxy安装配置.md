# smproxy 安装配置

文档: `https://smproxy.louislivi.com/`

## 安装

```shell
git clone https://github.com/louislivi/SMProxy.git smproxy
cd smproxy
docker build -t smproxy .
docker run -d --name=smproxy --network=app -v ${PWD}/conf/:/usr/local/smproxy/conf -v ${PWD}/logs/:/usr/local/smproxy/logs -p 3366:3366 smproxy
```

## 配置

只选择了一些常用更改项

### server.json

```json
{
  "swoole": {
    "worker_num": "必选，SWOOLE worker进程数，支持计算",
    "max_coro_num": "必选，SWOOLE 协程数，推荐不低于3000",
    "pid_file": "必选，worker进程和manager进程pid目录",
    "open_tcp_nodelay": "可选，关闭Nagle合并算法",
    "daemonize": "可选，守护进程化，true 为守护进程 false 关闭守护进程",
    "heartbeat_check_interval": "可选，心跳检测",
    "heartbeat_idle_time": "可选，心跳检测最大空闲时间",
    "reload_async": "可选，异步重启，true 开启异步重启 false 关闭异步重启",
    "log_file": "可选，SWOOLE日志目录"
  }
}
```

### database.json
