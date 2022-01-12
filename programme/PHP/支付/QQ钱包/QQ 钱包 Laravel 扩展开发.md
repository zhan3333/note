# QQ 钱包 Laravel 扩展开发

- [官方文档](https://qpay.qq.com/buss/doc.shtml)

## 接口列表

- 扫码支付
  - 统一下单
    - 生成支付二维码
  - 处理支付回调
  - 订单查询
  - 关闭订单
  - 申请退款
  - 退款查询
  - 对账单下载
- 企业付款
  - 付款给用户
  - 处理付款结果回调
  - 查询付款结果
  - 对账单下载

## 配置项

- `app_id` 商户id
- `secret_key` api 秘钥
- `api_client_cert_path` 证书pem路径
- `api_client_key_path` 证书秘钥pem路径
- `root_ca_path` CA证书
