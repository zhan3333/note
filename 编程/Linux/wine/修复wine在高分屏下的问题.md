# WINE 问题

## 高分屏下的显示问题


wechat

```shell
WINEPREFIX=~/.deepinwine/Deepin-WeChat /usr/bin/deepin-wine winecfg
```

tim
```shell
WINEPREFIX=~/.deepinwine/Deepin-TIM/ /usr/bin/deepin-wine winecfg
```

## 中文问题

在`/opt/deepinwine/tools/run.sh`中添加LC_ALL="zh_CN.UTF-8" 即可

## Ubuntu 下的托盘问题

安装扩展即可：`https://extensions.gnome.org/extension/1031/topicons/`

或者Ubuntu 19.10 在系统的软件中安装 topicons 即可