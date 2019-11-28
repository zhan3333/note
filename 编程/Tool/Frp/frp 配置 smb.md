# frp 配置 smb

smba 使用的是 tpc 协议，并且默认使用 445 端口，所以应该如下配置

```config
type = tcp
local_ip = 127.0.0.1
local_port = 445
remote_port = 44500
```
