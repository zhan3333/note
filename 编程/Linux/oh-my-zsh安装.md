# oh-my-zsh 安装

## wget安装

```shell
sh -c "$(wget -O- https://raw.githubusercontent.com/robbyrussell/oh-my-zsh/master/tools/install.sh)"
```

## 开启扩展

```shell
vim ~/.zshrc
```

## 推荐主题

```shell
ZSH_THEME="agnoster"
ZSH_THEME="ys"
```

## 安装字体 (修复`agnoster`主题乱码问题)

```shell
git clone https://github.com/powerline/fonts
cd fonts && ./install.sh
```

然后Terminal选择 `Ubuntu Mono derivative Powerline Regular` 字体

## 推荐扩展

`zsh-syntax-highlighting`：判断命令是否可用

```shell
git clone https://github.com/zsh-users/zsh-syntax-highlighting.git ${ZSH_CUSTOM:-~/.oh-my-zsh/custom}/plugins/zsh-syntax-highlighting
```

`zsh-autosuggestions`：历史命令建议

```shell
git clone https://github.com/zsh-users/zsh-autosuggestions ${ZSH_CUSTOM:-~/.oh-my-zsh/custom}/plugins/zsh-autosuggestions
```

`extract`: x命令解压文件

`git-open`

```shell script
git clone https://github.com/paulirish/git-open.git $ZSH_CUSTOM/plugins/git-open
```

`plugins=(其他的插件 git-open)`

## 最终使用配置为

```text
plugins=(git zsh-syntax-highlighting zsh-autosuggestions extract z git-open)
```

## 推荐打开功能

```shell
# 以下内容去掉注释即可生效：
# 启动错误命令自动更正
ENABLE_CORRECTION="true"

# 在命令执行的过程中，使用小红点进行提示
COMPLETION_WAITING_DOTS="true"
```
