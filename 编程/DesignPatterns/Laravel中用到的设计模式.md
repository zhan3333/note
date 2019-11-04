# Laravel 中使用到的设计模式

## 依赖注入模式 (Dependency Injection 实现 Inversion of Control)

在框架中，$app 对象是容器，其中的 $instances 数组保存已经实例化的对象，没有实例话的对象也有相对应的关联机制。使用一些服务对象时，将会从容器中取出，容器将按照设定好的解析规则返回实例化好的对象。
