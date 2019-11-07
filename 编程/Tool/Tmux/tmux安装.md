# tmux 安装

## 安装

```shell
wget https://github.com/tmux/tmux/releases/download/2.9/tmux-2.9.tar.gz
tar xzvf tmux-2.9.tar.gz
cd tmux-2.9
./configure
make && sudo make install
```

### 安装报错

`no acceptable C compiler found in $PATH`

```shell
sudo yum install gcc
```

`libevent not found`

CentOS

```shell
sudo yum install libevent-devel
```

Ubuntu

```shell
sudo yum install libevent-dev
```

`curses not found`

CentOS

```shell
 sudo yum install ncurses-devel
```

Ubuntu
```
sudo apt-get install ncurses-dev
```

## 配置

```shell
cd
git clone https://github.com/gpakosz/.tmux.git
ln -s -f .tmux/.tmux.conf
cp .tmux/.tmux.conf.local .
```

## tmux 安装 
