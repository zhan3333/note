https://github.com/docker/for-linux/issues/833

使用 disco 替代 $(lsb_release -cs)
```shell
sudo add-apt-repository \
   "deb [arch=amd64] https://download.docker.com/linux/ubuntu \
   disco \
   stable"
```

然后需要删除 `/etc/apt/sources.list` 中错误的 eoan 项