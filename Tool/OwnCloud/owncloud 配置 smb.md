# owncloud 配置 smb

## 配置选项

- 主机：不需要带 smb:// 前缀
- 共享：远程smb服务下的目录
- 远程子文件夹：可选，指定共享目录下的子目录
- 域名：WORKGROUP 通常空就可以了
- 用户名：nobody
- 密码：nobody

如果想要使用用户名密码的话，需要在SMB服务端用`smbpasswd $USER` 来配置一下该用户的SMB密码
