# tar 命令

- c 压缩
- x 解压
- v 显示过程
- f 文件名

## 压缩文件夹

- 压缩整个目录

```shell
tar -zcvf test.tar.gz test
```

- 压缩文件夹中的指定文件

```shell
tar -zcvf test.tar.gz a.txt b c.jpg
```

## 解压文件夹

```bash
tar -zxvf file.tar.gz
```

## 查看压缩文件内容

```shell
tar -tf file.tar.gz
```