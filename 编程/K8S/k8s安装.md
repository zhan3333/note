# k8s 安装

## 创建 TLS 证书和秘钥

使用 CloudFlare 的 PKI 工具集 `cfssl` 生成 CA 和其它证书

生成的证书包括： 

- ca-key.pem
- ca.pem
- kubernetes-key.pem
- kubernetes.pem
- kube-proxy.pem
- kube-proxy-key.pem
- admin.pem
- admin-key.pem

使用的证书组件如下：

- etcd: 使用 ca.pem、kubernetes-key.pem、kubernetes.pem
- kube-apiserver: 使用 ca.pem、kubernetes-key.pem、kubernetes.pem
- kubelet: 使用 ca.pem
- kube-proxy: 使用 ca.pem、kube-proxy-key.pem
- kubectl: 使用 ca.pem、admin-key.pem、admin.pem
- kube-controller-manager: 使用 ca-key.pem、ca.pem

安装过程中只需要在 master 节点主机上执行，证书只需要创建一次，新节点需要使用证书时，只需要将`/etc/kubernetes/`目录下的证书拷贝到新节点即可。

### 安装 CFSSL

以下命令需要使用 root 权限执行

```shell
wget https://pkg.cfssl.org/R1.2/cfssl_linux-amd64
chmod +x cfssl_linux-amd64
mv cfssl_linux-amd64 /usr/local/bin/cfssl

wget https://pkg.cfssl.org/R1.2/cfssljson_linux-amd64
chmod +x cfssljson_linux-amd64
mv cfssljson_linux-amd64 /usr/local/bin/cfssljson

wget https://pkg.cfssl.org/R1.2/cfssl-certinfo_linux-amd64
chmod +x cfssl-certinfo_linux-amd64
mv cfssl-certinfo_linux-amd64 /usr/local/bin/cfssl-certinfo
```

### 创建 CA (Certificate Authority)

使用 root 账号操作

```
mkdir /root/ssl
cd /root/ssl
cfssl print-defaults config > config.json
cfssl print-defaults csr > csr.json
# 根据config.json文件的格式创建如下的ca-config.json文件
# 过期时间设置成了 87600h
cat > ca-config.json <<EOF
{
  "signing": {
    "default": {
      "expiry": "87600h"
    },
    "profiles": {
      "kubernetes": {
        "usages": [
            "signing",
            "key encipherment",
            "server auth",
            "client auth"
        ],
        "expiry": "87600h"
      }
    }
  }
}
EOF
```

字段说明

- `ca-config.json`: 可以定义多个profiles，分别指定不同的过期时间、使用场景等参数；后续在签名证书时使用某个profile；
- `signing`：标识该证书可以用于签名其它证书；生成的ca.pem证书中 CA=TRUE;
- `server auth`: 表示client可以用该CA对server提供的证书进行验证；
- `client auth`: 标识server可以用该CA对client提供的证书进行验证；

### 创建 CA 证书签名请求

创建 `ca-csr.json` 文件，内容如下

```
{
  "CN": "kubernetes",
  "key": {
    "algo": "rsa",
    "size": 2048
  },
  "names": [
    {
      "C": "CN",
      "ST": "BeiJing",
      "L": "BeiJing",
      "O": "k8s",
      "OU": "System"
    }
  ],
    "ca": {
       "expiry": "87600h"
    }
}
```

- "CN": `Common Name`, kube-apiserver 从证书中提取该字段作为请求的用户名（User Name）；浏览器使用该字段验证网站是否合法。
- "O": `Organization`, kube-apiserver从证书中提取该字段作为请求用户所属的组(Group)；

### 生成CA证书和私钥

```shell
$ cfssl gencert -initca ca-csr.json | cfssljson -bare ca
$ ls ca*
ca-config.json  ca.csr  ca-csr.json  ca-key.pem  ca.pem
```

### 创建 kubernetes 证书

###

## 创建 kubeconfig 文件

## 创建高可用 etcd 集群

## 安装 kubectl 命令行工具

## 部署master节点

## 安装 flannel 网络插件

## 部署 node 节点

## 安装 kubedns 插件

## 安装 dashboard 插件

## 安装 heapster 插件

## 安装 EFK 插件