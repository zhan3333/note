# Golang Http 请求发送

## 发送一个 POST 表单提交

```golang
var request *http.Request
payload := make(url.Values)
payload.Add("wd", idCardIdentity.Name)
request, err := http.NewRequest(http.MethodPost, "https://www.baidu.com/s", strings.NewReader(payload.Encode()))
request.Header.Add("Content-Type", "application/x-www-form-urlencoded; charset=UTF-8")
response, err := http.DefaultClient.Do(request)
if err != nil {
  return err
}
defer func() {_ = response.Body.Close()}()
responseBody, err := ioutil.ReadAll(response.Body)
if err != nil {
  return err
}
log.Printf("response: %d %s",response.StatusCode, responseBody)
```

## POST json 数据

```golang
bodyJson, _ := json.Marshal(map[string]interface{}{
  "idNo": idCardIdentity.IdCard,
  "name": idCardIdentity.Name,
})
request, err := http.NewRequest(http.MethodPost, "https://www.baidu.com/s", strings.NewReader(string(bodyJson)))
```
