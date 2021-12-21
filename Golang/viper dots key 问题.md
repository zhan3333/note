# viper dots 作为 key 发现的一些问题

业务需求，使用 viper 来解析 json 配置文件并 Unmarshal 时，遇到了 json key 中带有 "." 符号的配置会报错: 

```go
func TestViperDotParse(t *testing.T) {
	str := `{
"test.a": "b"
}`
	vip := viper.New()
	vip.SetConfigType("json")
	assert.NoError(t, vip.ReadConfig(strings.NewReader(str)))
	m := map[string]string{}
	assert.NoError(t, vip.Unmarshal(&m))
	t.Log(m)
}
```

`* '[test]' expected type 'string', got unconvertible type 'map[string]interface {}'`

## 原因分析

原因是将 str "test.a" 处理为了

```json
{
    "test": {
        "a": "b"
    }
}
```

而不是我们期望的

```json
{
    "test.a": "b"
}
```

查 viper 源码，可以看到有这个选项在 Unmarshal 时起作用，具体到方法就是:

```go
func (v *Viper) AllSettings() map[string]interface{} {
	m := map[string]interface{}{}
	// start from the list of keys, and construct the map one value at a time
	for _, k := range v.AllKeys() {
		value := v.Get(k)
		if value == nil {
			continue
		}
        // keyDelim 配置起作用，会将 key 按照 keyDelim 拆分 key 作为了多层级的 key
		path := strings.Split(k, v.keyDelim)
		lastKey := strings.ToLower(path[len(path)-1])
		deepestMap := deepSearch(m, path[0:len(path)-1])
		// set innermost value
		deepestMap[lastKey] = value
	}
	return m
}
```


而 keyDelim 默认值是 ".", 所以在 Unmarshal 时会出错。好在 viper 提供了方法去更改 keyDelim:

```go
// KeyDelimiter sets the delimiter used for determining key parts.
// By default it's value is ".".
func KeyDelimiter(d string) Option {
	return optionFunc(func(v *Viper) {
		v.keyDelim = d
	})
}

// 将分隔符改为了 "::", 这样带 dots 的 key Unmamarshal 就不会有问题了
vip := viper.NewWithOptions(viper.KeyDelimiter("::"))
```

## 修改 keyDelim 后引发的问题


### SetDefault()

然而改为 "::" 后，`viper.SetDefault()` 会出问题，因为其内部也使用了 keyDelim 来设置默认值，看下面的栗子:

```go
vip := viper.NewWithOptions(viper.KeyDelimiter("::"))
s := struct{
    a struct {
        b string
    }
}
// 想要设置 b 的默认值, 下边的写法无效
vip.SetDefault("a.b", "c")

// 这种写法才是有效的 (因为分隔符已经被修改了)
vip.SetDefault("a::b", "c")
```

### SetEnvKeyReplacer()

同样的，在加载环境变量时，也会遇到这样的问题，需要更改 `. => ::`:

```go
vip.AutomaticEnv()

// 错误的做法
vip.SetEnvKeyReplacer(strings.NewReplacer(".", "_"))
// 正确的做法
vip.SetEnvKeyReplacer(strings.NewReplacer("::", "_"))
```

## 结论

1. 可以通过 `viper.KeyDelimiter("::")` 来避免 key 中有 . 符号的问题
2. 修改了 keyDelim 后，`SetDefault()` 时多级 key 需要用新的分隔符来设置
3. 修改了 keyDelim 后，`vip.SetEnvKeyReplacer(strings.NewReplacer("::", "_"))` 环境变量的读取也需要对应调整替换规则
4. yaml 应该也有类似的问题