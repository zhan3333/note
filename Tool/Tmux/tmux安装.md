# tmux 安装

## 安装

```shell
wget https://github.com/tmux/tmux/releases/download/3.2/tmux-3.2.tar.gz
tar xzvf tmux-3.2.tar.gz
cd tmux-3.2
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
sudo apt install libevent-dev
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

## tmux 安装 Resurrect

[resurrect](https://github.com/tmux-plugins/tmux-resurrect)

```shell
git clone https://github.com/tmux-plugins/tpm ~/.tmux/plugins/tpm
```

vim ~/.tmux.conf.local

```vim
set -g @tpm_plugins '          \
    tmux-plugins/tpm             \
    tmux-plugins/tmux-sensible   \
    tmux-plugins/tmux-resurrect  \
    tmux-plugins/tmux-continuum  \
'

set -g @resurrect-save 'S'
set -g @resurrect-restore 'R'
set -g @continuum-restore 'on'

run '~/.tmux/plugins/tpm/tpm'
```

在tmux中使用快捷键

`prefix + shift + i`安装插件
`prefix + shift + s` 保存
`prefix + shift + r` 重载