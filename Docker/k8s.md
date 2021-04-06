# K8S

Kubernetes 是一个开源的，用于管理云平台中多个主机上的容器化应用，目的是让部署容器化应用变得简单且高效。提供了应用部署、规划、更新、维护的机制。

## 容器编排的优缺点

1. 部署方便 (集群管理，环境统一)
2. 部署安全 （环境统一）
3. 隔离性好 （隔离宿主机的不同）
4. 快速回滚 （基于镜像版本的回滚）
5. 成本低 （相对于虚拟机有更少的资源消耗）
6. 管理成本更低 （较低的维护成本管理大量的容器集群）

## 容器部署和主机部署的区别

参考优缺点+主机与容器的比较。

主要讲 速度、效率、可靠性

## [3] K8S 常用组件, 结构

[参考文章](https://www.zhihu.com/search?type=content&q=Kubernetes%20%E7%BB%84%E4%BB%B6)

### 组件

master node: 是整个系统的指挥官

- API Server 整个系统的对外接口， 提供一套 Restful API 供客户端调用，例如 kubectl、kubernetes dashboard等管理工具 来对集群进行管理。
- Scheduler: 资源调度器， 监听 ApiServer 负责将容器组分配到哪些节点上。
- Controller: 是集群内所有资源对象的自动化控制中心，负责 Pod 和 Node 的管理，节点控制器，服务控制器，副本控制器，服务账户和令牌控制器等。
- etcd: 数据储存、储存集群中所有的配置信息
    - 网络插件： 储存网络配置信息
    - k8s 本身的各种对象的状态和原信息配置
- coredns: 实现集群内部通过服务名称进行容器组访问的功能。

worker node: 干活的小兵

- kubelet: 工作节点上的执行操作的代理程序，负责容器的生命周期管理，定期执行容器健康检查，并上报容器的运行状态。
- kube-proxy: 是一个具有均衡负载能力的简单的网络访问代理，负责将访问某个 service 的请求分配到工作节点的具体某个 pod 上（kube-proxy 也运行于 master node 上）
- Docker: 提供容器的创建及管理

均有使用的组件

- kube-flannel

### 主要操作对象

- Pod: 容器组，里面的每个容器共享网络空间命名空间（包括 IP 与端口），Pod 内的容器可以使用 localhost 互相通信。Pod 可以指定一组共享储存卷 Volumes， Pod 中所有容器都可以访问共享的 Volumes， Volumes 用于数据持久化，防止容器重要数据丢失
- Volume: 磁盘卷，用于防止重要数据丢失，以及多个 Pod 中多个容器间数据共享的问题。
    - EmptyDir: 当 Pod 分配到 Node 上时， 会创建 EmptyDir, 随 Pod 在 Node 上的删除而删除。
    - HostPath: 允许挂载 Node 上的文件系统到 Pod 里。
    - nfs： 使用 nfs 网络文件系统提供共享目录。
- ReplicationController: 确保任何时候都有按配置的 Pod 副本数在运行。
- ReplicaSet: 是下一代的 ReplicationController， 区别在于 Set 支持新的基于集合的选择器。
- Deployment: 为 Pod 与 ReplicaSet 提供了声明式的定义，描述想要的目标状态是什么样的， Deployment Controller 就会将 Pod 与 ReplicaSet 的实际状态改变到想要的目标状态。
- Service: 可以看作一组提供相同服务的 Pod 的对外访问接口
    - NodePort: 集群外部可以通过具体的 NodeIP + Node Port 来访问具体的某个 Pod
    - ClusterIP: 指通过集群的内部 IP 暴露服务， 服务只能够在集群内部可以访问，是默认的 ServiceType
- Label: 是一对 key/value, 可以附加到各种资源对象上，如 Node、Pod、Service 等。资源可以定义任意数量的 Label。可以通过 Label 选择一组资源。
- PV & PVC: 储存抽象
- Secret: 解决密码、token、密钥等敏感数据的储存问题
    - Service Account: 用来访问 Kubernetes API， 由 Kubernetes 自动创建， 并且会自动挂载到 Pod 的 /run/secrets/kubernetes.io/serviceac...目录中
    - Opaque: Base64编码的 Secret， 用来储存密码、密钥等。
    - dockerconfig.json： 储存 docker registry 的认证信息。
- ConfigMap: 保存 key/valud 对的配置数据， 可以在 Pods 中使用。
- Namespace: 虚拟集群，便于不同的分组在共享使用整个集群的资源同时还能被管理。例如开发测试共用一个 k8s 集群，就可以使用不同的 namespace
- Ingress: 为集群服务提供外部服务，包括 Nginx、Traefik 两个版本，为服务提供域名绑定访问与路径路由功能。也可以基于 Ingress 实现服务的灰度发布。

## 一个请求到达 pod 过程/configmap/dockerfile

## k8s 内部请求到达外部的过程

## etcd mvcc

基于数据库事务实现的乐观锁，在读取时，会读取当前事务ID下对应的值，这样可以避免写操作与读操作产生的锁操作影响性能。

内存中的 key->treeIndex->keyIndex 使用 btree 加速索引， keyIndex 对应 boltDB 中的 key/value 对

## k8s pod 之间如何通信

- 同一网络下的 Pod 通信

由于是共享网络空间的， 所以可以直接使用 localhost:port 来通信

- Pod 与 Pod 容器之间

1. 在同一台主机上

?

2. 在不同主机上

- Pod 访问 service 服务

通过 DNS 解析，访问 service name 即可访问到对应服务。

## k8s 集群网络

# Pod 创建过程

通过 ETCD 来储存 Kubectl 的请求。
各个组件通过访问 ApiServer 来获取请求。
ApiServer 通过 watch ETCD 的方式来缓存 ETCD 数据。
