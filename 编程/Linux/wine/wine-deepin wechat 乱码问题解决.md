# wine-deepin wechat 乱码问题解决

## 解决方案1

```shell
vim /opt/deepinwine/tools/run.sh
```

找到 `WINE_CMD`, 修改为 `WINE_CMD="LC_ALL=zh_CN.UTF-8 deepin-wine"`

## 解决方案2

1. 下载字体 `msyh.ttc`
2. 复制字体到目录中 `cp msyh.ttc ~/.deepinwine/Deepin-WeChat/drive_c/windows/Fonts`
3. 修改wechat系统注册表 `vim ~/.deepinwine/Deepin-WeChat/system.reg`

修改以下内容为
```
"MS Shell Dlg"="msyh"
"MS Shell Dlg 2"="msyh"
```

4. 字体注册

`vim msyh_config.reg`

添加以下内容

```
REGEDIT4
[HKEY_LOCAL_MACHINE\Software\Microsoft\Windows NT\CurrentVersion\FontLink\SystemLink]
"Lucida Sans Unicode"="msyh.ttc"
"Microsoft Sans Serif"="msyh.ttc"
"MS Sans Serif"="msyh.ttc"
"Tahoma"="msyh.ttc"
"Tahoma Bold"="msyhbd.ttc"
"msyh"="msyh.ttc"
"Arial"="msyh.ttc"
"Arial Black"="msyh.ttc"
```

注册`deepin-wine regedit msyh_config.reg`

5. 重启 `wechat`