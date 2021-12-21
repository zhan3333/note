## 参考

gin : [https://gin-gonic.com/docs/](https://gin-gonic.com/docs/)

gin git: [https://github.com/gin-gonic/gin](https://github.com/gin-gonic/gin)

路由前缀树的初始化与查找： [https://mp.weixin.qq.com/s?__biz=MzIyMTg0OTExOQ==&mid=2247485890&idx=2&sn=d3bffd0f4885f4004296edb60de6d273&chksm=e8373ab2df40b3a47e6b51836cb69154ba7dec0b6e6d6ab26117f9adc0edbdd50a8bc27a8a89&scene=27#wechat_redirect](https://mp.weixin.qq.com/s?__biz=MzIyMTg0OTExOQ==&mid=2247485890&idx=2&sn=d3bffd0f4885f4004296edb60de6d273&chksm=e8373ab2df40b3a47e6b51836cb69154ba7dec0b6e6d6ab26117f9adc0edbdd50a8bc27a8a89&scene=27#wechat_redirect)

gin example: [https://github.com/gin-gonic/examples](https://github.com/gin-gonic/examples)

## gin 是什么

高性能 http 框架，路由匹配算法基于 httprouter

## 为什么高性能

1. 压缩前缀树储存路由与执行方法映射, 节点储存部分路由路径
    1. 不用 hash? 因为有 : * 通配符
2. 请求几乎 0 内存分配，复用 Context
## 源码结构

### 目录结构

```plain
.
// 核心
├── gin.go: Engine 主要文件
├── response_writer.go: 封装 http.ResponseWriter
├── routergroup.go: 路由组与中间件
├── context.go: 上下文
├── tree.go: 路由树

// 提供的中间件
├── auth.go
├── logger.go
├── recovery.go

// 额外功能
├── binding: 参数绑定相关
│   ├── binding.go
│   ├── ...

// 不怎么重要
├── ginS: 内置 Engine 实例与方法，用户可以直接 gin.Run() 来使用这个内置的对象
│   ├── README.md
│   └── gins.go
├── errors.go: Context.Errors() 使用，提供了一些格式化例如 JSON() 等方法
├── fs.go: 文件读取的辅助方法
├── mode.go: env 处理
├── path.go: 提供 url 处理函数
├── internal
│   ├── bytesconv
│   │   ├── bytesconv.go: byte string 免复制互转
│   └── json: json 序列化使用不同的包，可以在编译程序时指定
│       ├── go_json.go
│       ├── json.go
│       └── jsoniter.go
├── render: Render 的多种实现
│   ├── json.go
│   ├── ...
├── test_helpers.go: 辅助编写测试代码
├── utils.go: 辅助方法
├── context_appengine.go: 配置了可以信任的平台，当前是 google-app-engine. X-Appengine-Remote-Addr 
├── debug.go: 一些辅助 debug 信息输出
├── deprecated.go: 一些将要废弃的方法会放在这里, 调用时会有日志警告
└── version.go: 存放 gin 的版本号

```
### 逻辑结构

* Engine
    * ServeHTTP(): 处理请求
    * Run(): 启动服务
    * trees: 路由树
        * node: 路由节点
            * addRoute(): 添加路由
            * getValue(): 查找路由
* RouteGroup
    * Group(): 添加路由组
    * Use(): 使用中间件
    * Handle(): 添加路由
* Context: 请求上下文
    * handles: 当前请求会执行的中间件与控制器
    * Request: http.Request
    * Write: ResponseWriter
## 启动流程

1. 创建 Engine
2. 添加路由
3. 运行服务
### 运行一个服务

```go
r := gin.Default()
r.GET("/", func(c *gin.Context) {
   c.String(http.StatusOK, "ok")
})
if err := r.Run(":8080"); err != nil {
  panic(err)
}
```
### gin.Default() 内主要调用 gin.New() 方法

```go
func New() *Engine {
   // Engine 实现了 IRouter, IRoutes 接口, 故可以直接调用路由组等方法
   engine := &Engine{
      // 路由组配置，主要对路由分组并设置组使用的中间件列表
      RouterGroup: RouterGroup{
         // 放中间件和控制器
         Handlers: nil,
         // 服务于路由组
         basePath: "/",
         root:     true,
      },
      ...
      MaxMultipartMemory:     defaultMultipartMemory,
      ...
      // (重点)路由字典树
      trees:                  make(methodTrees, 0, 9),
   }
   engine.RouterGroup.engine = engine
   // context 池
   engine.pool.New = func() interface{} {
      return engine.allocateContext()
   }
   return engine
}

// 创建 Context
func (engine *Engine) allocateContext() *Context {
   // 根据通配符最大数量来初始化，减少内存分配
   v := make(Params, 0, engine.maxParams)
   return &Context{engine: engine, params: &v}
}

```
### Engine.Run()

```go
func (engine *Engine) Run(addr ...string) (err error) {
   address := resolveAddress(addr)
   // Engine 实现了 http.Handler 接口, 所以可以直接 ListenAndServe
   err = http.ListenAndServe(address, engine)
   return
}

// 接口
type Handler interface {
   ServeHTTP(ResponseWriter, *Request)
}

```
Engine.ServeHTTP() 是处理请求的起点，我们单独讲
## 设置路由与中间件

```go
func main() {
  r := gin.New()
  api := r.Group("/api", Middle1()) {
    api.Use(Middle2())
    api.POST("/login", Middle3(), Login())
  }
}

// 最终，/api/login 会经过 Middle1(), Middle2(), Middle3() 三个中间件后，再执行 Login() 方法
```
### RouterGroup 对象与关键方法

```go
// 可以理解为路由的配置信息, 关键看下边几个提供的方法
// 另外提供了 GET, POST, PUT 等 http 路由设置方法
// 实现了 IRouter, IRoutes 接口
type RouterGroup struct {
	Handlers HandlersChain
	basePath string
	engine   *Engine
    // gin.New() 时创建的是根路由, basePath 通常为 /
	root     bool
}

// 向路由组添加中间件
// 例如 r.Use(Logger(), Recovery())
func (group *RouterGroup) Use(middleware ...HandlerFunc) IRoutes {
   group.Handlers = append(group.Handlers, middleware...)
   return group.returnObj()
}

// new 一个 RouterGroup, 指定相对路径
// 在这个路由组中的路由都要由当前路由组来设置
// 例如:
// auth := r.Group("/auth")
// {
//    auth.POST("/login", func(c *gin.Context) {c.Status(200)})
// }
// 上述代码创建了路由 POST /auth/login
func (group *RouterGroup) Group(relativePath string, handlers ...HandlerFunc) *RouterGroup {
   return &RouterGroup{
      // 合并路由组和新建路由组传入的 Handlers
      Handlers: group.combineHandlers(handlers),
      // 合并路径，例如 group.basePath="/auth", relativePath="/login"
      // 那么这里的结果就是 "/auth/login"
      basePath: group.calculateAbsolutePath(relativePath),
      // gin Engine 对象指针
      engine:   group.engine,
   }
}

// 向 RouterGroup 中添加路由
// httpMethod: GET、POST 等
func (group *RouterGroup) Handle(httpMethod, relativePath string, handlers ...HandlerFunc) IRoutes {
   if matches, err := regexp.MatchString("^[A-Z]+$", httpMethod); !matches || err != nil {
      panic("http method " + httpMethod + " is not valid")
   }
   return group.handle(httpMethod, relativePath, handlers)
}

// 和 Group() 类似，也会合并路径和中间件
// 不同的是有 engine.addRoute() 添加路由到路由树
func (group *RouterGroup) handle(httpMethod, relativePath string, handlers HandlersChain) IRoutes {
   absolutePath := group.calculateAbsolutePath(relativePath)
   handlers = group.combineHandlers(handlers)
   group.engine.addRoute(httpMethod, absolutePath, handlers)
   return group.returnObj()
}
```
### IRouter 与 IRoutes

```go
// 路由组接口
// Engine、RouterGroup 均实现了该接口，所以我们能 gin.New() 之后直接设置路由组与路由
// 可以当 Engine 实例为一个根路由组来使用
type IRouter interface {
   IRoutes
   // 创建一个路由组
   Group(string, ...HandlerFunc) *RouterGroup
}

// IRoutes 定义了所有可以被添加为路由的方法
type IRoutes interface {
   // 向 RouterGroup.Handlers 中间件列表添加数据
   Use(...HandlerFunc) IRoutes
   
   Handle(string, string, ...HandlerFunc) IRoutes
   // 以下方法的实现均为 Handle() 的封装
   Any(string, ...HandlerFunc) IRoutes
   GET(string, ...HandlerFunc) IRoutes
   POST(string, ...HandlerFunc) IRoutes
   DELETE(string, ...HandlerFunc) IRoutes
   PATCH(string, ...HandlerFunc) IRoutes
   PUT(string, ...HandlerFunc) IRoutes
   OPTIONS(string, ...HandlerFunc) IRoutes
   HEAD(string, ...HandlerFunc) IRoutes
   
   // 上述方法的组合
   StaticFile(string, string) IRoutes
   Static(string, string) IRoutes
   StaticFS(string, http.FileSystem) IRoutes
}
```
### IRoutes.GET()

```go
// GET Handle() 的封装
func (group *RouterGroup) GET(relativePath string, handlers ...HandlerFunc) IRoutes {
   return group.handle(http.MethodGet, relativePath, handlers)
}

// 添加路由
func (group *RouterGroup) handle(httpMethod, relativePath string, handlers HandlersChain) IRoutes {
   // 计算路由的绝对路径
   absolutePath := group.calculateAbsolutePath(relativePath)
   // 合并中间件 (包括控制器，控制器可以看作是最后一个中间件)
   handlers = group.combineHandlers(handlers)
   // 向 engine.trees 中添加映射关系
   group.engine.addRoute(httpMethod, absolutePath, handlers)
   return group.returnObj()
}

// engine 添加路由核心逻辑
func (engine *Engine) addRoute(method, path string, handlers HandlersChain) {
   assert1(path[0] == '/', "path must begin with '/'")
   assert1(method != "", "HTTP method can not be empty")
   assert1(len(handlers) > 0, "there must be at least one handler")
   ...
   // 中 trees 中取出 method 对应 tree
   root := engine.trees.get(method)
   ...
   // 将路由添加到 tree 上, 详见下文 Engine.tress
   root.addRoute(path, handlers)
   // 更新所有路由中最大通配符参数数量
   if paramsCount := countParams(path); paramsCount > engine.maxParams {
      engine.maxParams = paramsCount
   }
   // 更新所有路由中最大长度 (树的最大深度)
   if sectionsCount := countSections(path); sectionsCount > engine.maxSections {
      engine.maxSections = sectionsCount
   }
}
```

## 请求处理流程

整个请求处理流程主要是 Context 的使用

我们记得 engine 实现了 http.Handler 接口，收到请求时会首先调用 engine.Handler()

```go
func (engine *Engine) ServeHTTP(w http.ResponseWriter, req *http.Request) {
   c := engine.pool.Get().(*Context)
   // response 设置
   c.writermem.reset(w)
   // request 设置
   c.Request = req
   // 重置 ctx
   c.reset()
   // 开始处理请求
   engine.handleHTTPRequest(c)
   // 回收 ctx
   engine.pool.Put(c)
}
```
### Context

context 是 gin 的重点, 主要用于在中间件执行过程中传递上下文，主要包含 6 个部分:

1. 创建 Context: reset(), Copy() 等
2. 流程控制: Next(), Abort() 等
3. 错误处理: Error()
4. 上下文数据管理: Set(), Get()
5. 请求参数处理
    1. Param(): url 参数
    2. Query(): url query params
    3. PostForm(): 表单参数
    4. FormFile(): 表单文件
    5. Bind(): 参数绑定
6. 响应处理
    1. Render()
我们看看 Context 的结构

```go
type Context struct {
    Request      *http.Request
    Writer       ResponseWriter

    // 请求参数
    Params       Params
    queryCache   url.Values
    formCache    url.Values

    // 中间件与下标信息
    handlers     HandlersChain
    index        int8

    // key value 储存及读写锁
    mu           sync.RWMutex
    Keys         map[string]interface{}
    
    // 中间件运行过程可以用这个存放错误，主要用途在于请求结束后统一记录或处理错误
    Errors       errorMsgs
}

```
取几个关键方法讲一下
#### Set() Get()

```go
// 设置 key value, 主要用途是在 ctx 传递过程中携带一些信息
// 有读写锁
// 例如: auth 中间件解析出来 userID, 可以通过 ctx.Set("userID", uid) 来传递
// 当然也有通过自定义 Context 来传递信息的，需要一些特殊的写法，下文再讲
func (c *Context) Set(key string, value interface{}) {
	c.mu.Lock()
	if c.Keys == nil {
		c.Keys = make(map[string]interface{})
	}

	c.Keys[key] = value
	c.mu.Unlock()
}

// 取值，有读写锁
func (c *Context) Get(key string) (value interface{}, exists bool) {
	c.mu.RLock()
	value, exists = c.Keys[key]
	c.mu.RUnlock()
	return
}
```
#### FormFile()

获取上传文件也挺有意思的，我们来看一下

```go
func (c *Context) FormFile(name string) (*multipart.FileHeader, error) {
   // 用到时才会去解析请求表单
   if c.Request.MultipartForm == nil {
      if err := c.Request.ParseMultipartForm(c.engine.MaxMultipartMemory); err != nil {
         return nil, err
      }
   }
   f, fh, err := c.Request.FormFile(name)
   if err != nil {
      return nil, err
   }
   f.Close()
   return fh, err
}

// 这里是 http.Reqeust 的方法了
// 解析表单参数 multipart/form-data
// maxMemory 限制了 file 类型参数的大小，<= maxMemory 存在内存中，> maxMemory 存在临时文件中
// gin 默认传入值为 32M
// 内存有限的话，可以考虑调小 maxMemory
func (r *Request) ParseMultipartForm(maxMemory int64) error {
   
   // 解析 body 参数及 url 参数
   // 特别的，不处理 multipart/form-data 时的参数，文档写是因为太复杂
   // 单独拿到下面的 ReadForm() 来处理
   parseFormErr = r.ParseForm()

   mr, err := r.multipartReader(false)
   
   // 读取 multipart/form-data 时的参数, 见下文 readForm()
   f, err := mr.ReadForm(maxMemory)
   
   if r.PostForm == nil {
      r.PostForm = make(url.Values)
   }
   for k, v := range f.Value {
      r.Form[k] = append(r.Form[k], v...)
      // r.PostForm should also be populated. See Issue 9305.
      r.PostForm[k] = append(r.PostForm[k], v...)
   }
   r.MultipartForm = f
   return parseFormErr
}

// 读取 multipart/form-data 时的参数
func (r *Reader) readForm(maxMemory int64) (_ *Form, err error) {
   form := &Form{make(map[string][]string), make(map[string][]*FileHeader)}

   for {
      p, err := r.NextPart()
      if err == io.EOF {
         break
      }
      if err != nil {
         return nil, err
      }
      name := p.FormName()
      if name == "" {
         continue
      }
      filename := p.FileName()
      var b bytes.Buffer
      // 没传 filename 时当作字符串参数处理
      if filename == "" {
         // value, store as string in memory
         n, err := io.CopyN(&b, p, maxValueBytes+1)
         if err != nil && err != io.EOF {
            return nil, err
         }
         maxValueBytes -= n
         if maxValueBytes < 0 {
            return nil, ErrMessageTooLarge
         }
         form.Value[name] = append(form.Value[name], b.String())
         continue
      }
      // file, store in memory or on disk
      fh := &FileHeader{
         Filename: filename,
         Header:   p.Header,
      }
      // 读 maxMeory+1 到内存中
      n, err := io.CopyN(&b, p, maxMemory+1)
      if err != nil && err != io.EOF {
         return nil, err
      }
      if n > maxMemory {
         // 超过传入的 maxMemory 了，创建临时文件写到文件中
         // too big, write to disk and flush buffer
         file, err := os.CreateTemp("", "multipart-")
         if err != nil {
            return nil, err
         }
         size, err := io.Copy(file, io.MultiReader(&b, p))
         if cerr := file.Close(); err == nil {
            err = cerr
         }
         if err != nil {
            os.Remove(file.Name())
            return nil, err
         }
         fh.tmpfile = file.Name()
         fh.Size = size
      } else {
         fh.content = b.Bytes()
         fh.Size = int64(len(fh.content))
         // 上传多个文件共用一个内存上限
         maxMemory -= n
         maxValueBytes -= n
      }
      form.File[name] = append(form.File[name], fh)
   }
   return form, nil
}
```
#### Copy()

假如你要将 ctx 传入协程中使用，需要 Copy() 一下去安全的使用 （除非知道自己在做啥）

1. 核心原因：请求结束后 ctx 会 put 到 pool 中给下个请求使用
2. 中间件信息、响应以及一些请求参数会对下次请求有影响
3. 协程中 response write 不确定顺序，不能在协程中使用
```go
func (c *Context) Copy() *Context {
   cp := Context{
      writermem: c.writermem,
      Request:   c.Request,
      Params:    c.Params,
      engine:    c.engine,
   }
   // 移除 response
   cp.writermem.ResponseWriter = nil
   cp.Writer = &cp.writermem
   // 禁止调用 Next()
   cp.index = abortIndex // 63
   cp.handlers = nil
   // 一些参数数据需要复制避免影响下次请求
   cp.Keys = map[string]interface{}{}
   for k, v := range c.Keys {
      cp.Keys[k] = v
   }
   paramCopy := make([]Param, len(cp.Params))
   copy(paramCopy, cp.Params)
   cp.Params = paramCopy
   return &cp
}
```

#### reset()

开始一个请求时，从 pool 中取出一个 ctx 使用时，先要 reset 清空上次请求留下的一些信息

```go
func (c *Context) reset() {
   c.Writer = &c.writermem
   c.Params = c.Params[:0]
   c.handlers = nil
   c.index = -1
   c.fullPath = ""
   c.Keys = nil
   c.Errors = c.Errors[:0]
   c.Accepted = nil
   c.queryCache = nil
   c.formCache = nil
   *c.params = (*c.params)[:0]
}
```

### 开始处理请求

```go
// gin 处理请求逻辑
func (engine *Engine) handleHTTPRequest(c *Context) {
   httpMethod := c.Request.Method
   ...
   t := engine.trees
   for i, tl := 0, len(t); i < tl; i++ {
      if t[i].method != httpMethod {
         continue
      }
      // 找到 method 对应的 tree
      root := t[i].root
      // 找到 tree 中本次请求对应的路由
      // todo: 放到 Engine.trees 一起讲怎么去找到节点
      value := root.getValue(rPath, c.params, c.skippedNodes, unescape)
      if value.params != nil {
         c.Params = *value.params
      }
      // 路由有对应的中间件的话，在这一部分执行中间件
      if value.handlers != nil {
         c.handlers = value.handlers
         c.fullPath = value.fullPath
         // gin 的中间件执行比较有意思，也单独讲
         c.Next()
         c.writermem.WriteHeaderNow()
         return
      }
      ...
      break
   }
   // 路由未找到时，如果 path 有对应的其他 method 支持，将会响应 405 并告诉客户端服务器支持的 methods
   if engine.HandleMethodNotAllowed {
      for _, tree := range engine.trees {
         if tree.method == httpMethod {
            continue
         }
         if value := tree.root.getValue(rPath, nil, c.skippedNodes, unescape); value.handlers != nil {
            c.handlers = engine.allNoMethod
            serveError(c, http.StatusMethodNotAllowed, default405Body)
            return
         }
      }
   }
   // 如果配置了 noRoute 中间件，那么会执行这些中间件
   // 否则响应默认的 404 msg
   c.handlers = engine.allNoRoute
   serveError(c, http.StatusNotFound, default404Body)
}
```
### [执行中间件与控制器] ctx 执行 Next()

```go
// 中间件执行
// 为啥用 index 而不直接 for 呢？
// 是为了实现中间件 abort 中断后续中间件的执行
func (c *Context) Next() {
   // c.index reset() 时设置为了 -1，这里 ++为 0
   c.index++
   for c.index < int8(len(c.handlers)) {
      c.handlers[c.index](c)
      c.index++
   }
}
```
我们记得在添加中间件的时候用到了 combineHandlers() 方法，这个方法限制了中间件的数量
```go
const abortIndex int8 = math.MaxInt8 / 2  // =63

func (group *RouterGroup) combineHandlers(handlers HandlersChain) HandlersChain {
	finalSize := len(group.Handlers) + len(handlers)
    // 看这里
	if finalSize >= int(abortIndex) {
		panic("too many handlers")
	}
	mergedHandlers := make(HandlersChain, finalSize)
	copy(mergedHandlers, group.Handlers)
	copy(mergedHandlers[len(group.Handlers):], handlers)
	return mergedHandlers
}
```
而中间件中中断的主要方法为
```go
func (c *Context) Abort() {
	c.index = abortIndex // =63
}
```
也就是说调用了 ctx.Abort() 后，c.index < int8(len(c.handlers)) 不成立后续中间件就不会执行了。
### [写 response] ctx 执行 Render()

```go
// 将结果写到 response 中
// 是 c.String(), c.Status(), c.JSON() c.HTML() 的执行的位置
func (c *Context) Render(code int, r render.Render) {
   c.Status(code)
   // status code 是否允许 body 响应
   if !bodyAllowedForStatus(code) {
      r.WriteContentType(c.Writer)
      c.Writer.WriteHeaderNow()
      return
   }
   if err := r.Render(c.Writer); err != nil {
      panic(err)
   }
}



// render.Render 接口
type Render interface {
   Render(http.ResponseWriter) error
   WriteContentType(w http.ResponseWriter)
}
```
这些方法会调用 Render()
```go
HTML(code int, name string, obj interface{})
IndentedJSON(code int, obj interface{})
SecureJSON(code int, obj interface{})
JSONP(code int, obj interface{})
JSON(code int, obj interface{})
AsciiJSON(code int, obj interface{})
PureJSON(code int, obj interface{})
XML(code int, obj interface{})
YAML(code int, obj interface{})
ProtoBuf(code int, obj interface{})
String(code int, format string, values ...interface{})
Redirect(code int, location string)
Data(code int, contentType string, data []byte)
DataFromReader(code int, contentLength int64, contentType string, reader io.Reader, extraHeaders map[string]string)
```
## trees (代码分析跳过)

### 是什么

压缩前缀树, 使用的 httprouter 的代码，使用 BSD 许可证: [https://github.com/julienschmidt/httprouter/blob/master/LICENSE](https://github.com/julienschmidt/httprouter/blob/master/LICENSE)

gin 对一些代码做了优化

### 长什么样

我们可以用一些代码，打印一下树的结构与信息

```go
// 打印一下路由树
// 1. 斜杠也算在节点 path 内
// 2. 路由添加时会匹配最长公共前缀来决定挂在哪个节点下, 与已存在的节点有公共前缀且节点不完全为 path 前缀时，节点会将前缀单独拆分为节点
func TestTree(t *testing.T) {
   app := New()
   // GET tree
   app.GET("/", func(context *Context) {})
   app.GET("/api/user/profile", func(c *Context) {})
   app.GET("/api/user/:id/name", func(c *Context) {})
   app.GET("/api/user/:id/age", func(c *Context) {})
   app.GET("/api/user/:id", func(c *Context) {})
   app.GET("/api/users", func(c *Context) {})
   app.GET("/api/users/list", func(c *Context) {})
   // POST tree
   app.POST("/api/:version", func(c *Context) {})
   app.POST("/api/user", func(c *Context) {})
   for _, tree := range app.trees {
      fmt.Println("tree method: ", tree.method)
      Dump(printTree(tree.root))
   }
}
// 转为 json, 然后利用 json 序列化输出展示出来
// 响应
// {
//    "p1": {
//       "p2": {
//       },
//       "p3": {
//       }
//    }
// }
func printTree(root *node) map[string]interface{} {
   ret := map[string]interface{}{}
   if root == nil {
      return ret
   }
   childs := map[string]interface{}{}
   for _, node := range root.children {
      for _, NodeVal := range printTree(node) {
         childs[printNode(node)] = NodeVal
      }
   }
   ret[printNode(root)] = childs
   return ret
}
func printNode(node *node) string {
   //return fmt.Sprintf("%s|%s|%t|%d", node.path, node.indices, node.wildChild, node.nType)
   return fmt.Sprintf("%s", node.path)
}
```
运行 TestTree 我们可以得到以下输出
![图片](data:image/png;base64,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)

### 节点结构

```go
type Engine struct {
    trees methodTrees
}

// Enginer.trees
type methodTrees []methodTree

// 方法树，不同的 http method 拥有不同的树
type methodTree struct {
    // GET、POST 等
	method string
    // 树节点
	root   *node
}

type node struct {
   // 表示当前节点的 path, 可以理解为节点的值
   path      string
   // 通常情况下维了 children 列表的 path 的各首字符组成的 string。在处理通配符路径时会有特殊情况
   indices   string
   // 默认 false，当 children 是通配符类型时，为 true
   wildChild bool
   // 节点类型
   // static 普通节点
   // root 根节点
   // param : 节点
   // catchAll * 节点
   nType     nodeType
   // 记录有多少条路由会经过该节点，用于在节点排序时使用
   priority  uint32
   children  []*node // child nodes, at most 1 :param style node at the end of the array
   // 叶子节点时，包含处理中间件与控制器；非叶子节点则为 nil
   handlers  HandlersChain
   // 根节点到当前节点的全部 path
   fullPath  string
}
```
### 添加节点

```go
// 为 node 添加子节点
// 注意 path 是绝对路径
// 插入是从根节点开始的
func (n *node) addRoute(path string, handlers HandlersChain) {
   fullPath := path
   // 统计经过该节点的路由个数
   n.priority++
   // 根节点没有子节点时，path 直接作为子节点插入
   if len(n.path) == 0 && len(n.children) == 0 {
      n.insertChild(path, fullPath, handlers)
      n.nType = root
      return
   }
   parentFullPathIndex := 0
walk:
   for {
      // 查找最长公共前缀
      i := longestCommonPrefix(path, n.path)
      // 如果公共前缀部分小于当前节点 path, 则分裂当前节点，前部分保留，后部分变为一个子节点
      // 例如
      // n.path: /api/users
      // path: /api/user/profile
      // 此时公共前缀为 /api/user, 所以 n.path=/api/user
      // 新增一个子节点: n.children[x]=/s
      if i < len(n.path) {
         child := node{
            // 当前节点非公共部分变为子节点
            path:      n.path[i:],
            wildChild: n.wildChild,
            indices:   n.indices,
            children:  n.children,
            handlers:  n.handlers,
            priority:  n.priority - 1,
            fullPath:  n.fullPath,
         }
         n.children = []*node{&child}
         // []byte for proper unicode char conversion, see #65
         n.indices = bytesconv.BytesToString([]byte{n.path[i]})
         // 当前节点 path 变为公共部分
         n.path = path[:i]
         n.handlers = nil
         n.wildChild = false
         n.fullPath = fullPath[:parentFullPathIndex+i]
      }
      // 当 path 还有非公共前缀部分时，这部分成为一个子节点
      if i < len(path) {
         path = path[i:]
         c := path[0]
         // 当前节点为 : 通配符节点，新节点为普通节点，且子节点只有一个时
         // 交给子节点处理
         // 原因是 : 通配符节点不会存在
         // 例如:
         // 当前节点:
         // {
         //   "path": "/:name",
         //   "children": [
         //      {"path": "/age"}
         //    ]
         // }
         // 插入 path: /:name/title 时
         // 执行到这里了 path=/title
         // 当前节点会被设置为 path: /age
         // 返回到开头再进行匹配，生成的结果为
         // {
         //   "/": [
         //      {"path": "age"},
         //      {"path": "title"}
         //   ] 
         // }
         // 这个结果会作为 path: /:name 节点的子节点
         //
         if n.nType == param && c == '/' && len(n.children) == 1 {
            parentFullPathIndex += len(n.path)
            n = n.children[0]
            n.priority++
            continue walk
         }
         // 当前节点存在子节点与插入 path 有相同前缀，则 path 交给这个子节点处理
         for i, max := 0, len(n.indices); i < max; i++ {
            if c == n.indices[i] {
               parentFullPathIndex += len(n.path)
               i = n.incrementChildPrio(i)
               n = n.children[i]
               continue walk
            }
         }
         // 普通 path 插入，且当前节点非 * 通配符节点
         // 会作为子节点插入
         if c != ':' && c != '*' && n.nType != catchAll {
            // []byte for proper unicode char conversion, see #65
            // 更新 indices 子节点首字符表
            n.indices += bytesconv.BytesToString([]byte{c})
            child := &node{
               fullPath: fullPath,
            }
            n.addChild(child)
            n.incrementChildPrio(len(n.indices) - 1)
            n = child
         } else if n.wildChild {
            // 太复杂还没理解...
            // inserting a wildcard node, need to check if it conflicts with the existing wildcard
            n = n.children[len(n.children)-1]
            n.priority++
            // Check if the wildcard matches
            if len(path) >= len(n.path) && 
               n.path == path[:len(n.path)] &&
               // Adding a child to a catchAll is not possible
               n.nType != catchAll &&
               // Check for longer wildcard, e.g. :name and :names
               (len(n.path) >= len(path) || path[len(n.path)] == '/') {
               continue walk
            }
            // Wildcard conflict
            pathSeg := path
            if n.nType != catchAll {
               pathSeg = strings.SplitN(pathSeg, "/", 2)[0]
            }
            prefix := fullPath[:strings.Index(fullPath, pathSeg)] + n.path
            panic("'" + pathSeg +
               "' in new path '" + fullPath +
               "' conflicts with existing wildcard '" + n.path +
               "' in existing prefix '" + prefix +
               "'")
         }
         n.insertChild(path, fullPath, handlers)
         return
      }
      // Otherwise add handle to current node
      if n.handlers != nil {
         panic("handlers are already registered for path '" + fullPath + "'")
      }
      n.handlers = handlers
      n.fullPath = fullPath
      return
   }
}

// 查找最长公共前缀
func longestCommonPrefix(a, b string) int {
   i := 0
   max := min(len(a), len(b))
   for i < max && a[i] == b[i] {
      i++
   }
   return i
}

```
### 查找节点

```go
func (n *node) getValue(path string, params *Params, unescape bool) (value nodeValue) {
   var (
      skippedPath string
      latestNode  = n // Caching the latest node
   )
walk: // Outer loop for walking the tree
   for {
      prefix := n.path
      if len(path) > len(prefix) {
         if path[:len(prefix)] == prefix {
            path = path[len(prefix):]
            // Try all the non-wildcard children first by matching the indices
            // 优先考虑非通配符节点
            idxc := path[0]
            for i, c := range []byte(n.indices) {
               if c == idxc {
                  //  strings.HasPrefix(n.children[len(n.children)-1].path, ":") == n.wildChild
                  if n.wildChild {
                     skippedPath = prefix + path
                     latestNode = &node{
                        path:      n.path,
                        wildChild: n.wildChild,
                        nType:     n.nType,
                        priority:  n.priority,
                        children:  n.children,
                        handlers:  n.handlers,
                        fullPath:  n.fullPath,
                     }
                  }
                  n = n.children[i]
                  continue walk
               }
            }
            // If the path at the end of the loop is not equal to '/' and the current node has no child nodes
            // the current node needs to be equal to the latest matching node
            matched := path != "/" && !n.wildChild
            if matched {
               n = latestNode
            }
            // If there is no wildcard pattern, recommend a redirection
            if !n.wildChild {
               // Nothing found.
               // We can recommend to redirect to the same URL without a
               // trailing slash if a leaf exists for that path.
               value.tsr = path == "/" && n.handlers != nil
               return
            }
            // Handle wildcard child, which is always at the end of the array
            n = n.children[len(n.children)-1]
            switch n.nType {
            case param:
               // fix truncate the parameter
               // tree_test.go  line: 204
               if matched {
                  path = prefix + path
                  // The saved path is used after the prefix route is intercepted by matching
                  if n.indices == "/" {
                     path = skippedPath[1:]
                  }
               }
               // Find param end (either '/' or path end)
               end := 0
               for end < len(path) && path[end] != '/' {
                  end++
               }
               // Save param value
               if params != nil && cap(*params) > 0 {
                  if value.params == nil {
                     value.params = params
                  }
                  // Expand slice within preallocated capacity
                  i := len(*value.params)
                  *value.params = (*value.params)[:i+1]
                  val := path[:end]
                  if unescape {
                     if v, err := url.QueryUnescape(val); err == nil {
                        val = v
                     }
                  }
                  (*value.params)[i] = Param{
                     Key:   n.path[1:],
                     Value: val,
                  }
               }
               // we need to go deeper!
               if end < len(path) {
                  if len(n.children) > 0 {
                     path = path[end:]
                     n = n.children[0]
                     continue walk
                  }
                  // ... but we can't
                  value.tsr = len(path) == end+1
                  return
               }
               if value.handlers = n.handlers; value.handlers != nil {
                  value.fullPath = n.fullPath
                  return
               }
               if len(n.children) == 1 {
                  // No handle found. Check if a handle for this path + a
                  // trailing slash exists for TSR recommendation
                  n = n.children[0]
                  value.tsr = n.path == "/" && n.handlers != nil
               }
               return
            case catchAll:
               // Save param value
               if params != nil {
                  if value.params == nil {
                     value.params = params
                  }
                  // Expand slice within preallocated capacity
                  i := len(*value.params)
                  *value.params = (*value.params)[:i+1]
                  val := path
                  if unescape {
                     if v, err := url.QueryUnescape(path); err == nil {
                        val = v
                     }
                  }
                  (*value.params)[i] = Param{
                     Key:   n.path[2:],
                     Value: val,
                  }
               }
               value.handlers = n.handlers
               value.fullPath = n.fullPath
               return
            default:
               panic("invalid node type")
            }
         }
      }
      if path == prefix {
         // If the current path does not equal '/' and the node does not have a registered handle and the most recently matched node has a child node
         // the current node needs to be equal to the latest matching node
         if latestNode.wildChild && n.handlers == nil && path != "/" {
            n = latestNode.children[len(latestNode.children)-1]
         }
         // We should have reached the node containing the handle.
         // Check if this node has a handle registered.
         if value.handlers = n.handlers; value.handlers != nil {
            value.fullPath = n.fullPath
            return
         }
         // If there is no handle for this route, but this route has a
         // wildcard child, there must be a handle for this path with an
         // additional trailing slash
         if path == "/" && n.wildChild && n.nType != root {
            value.tsr = true
            return
         }
         // No handle found. Check if a handle for this path + a
         // trailing slash exists for trailing slash recommendation
         for i, c := range []byte(n.indices) {
            if c == '/' {
               n = n.children[i]
               value.tsr = (len(n.path) == 1 && n.handlers != nil) ||
                  (n.nType == catchAll && n.children[0].handlers != nil)
               return
            }
         }
         return
      }
      if path != "/" && len(skippedPath) > 0 && strings.HasSuffix(skippedPath, path) {
         path = skippedPath
         // Reduce the number of cycles
         n, latestNode = latestNode, n
         // skippedPath cannot execute
         // example:
         // * /:cc/cc
         // call /a/cc       expectations:match/200      Actual:match/200
         // call /a/dd       expectations:unmatch/404    Actual: panic
         // call /addr/dd/aa  expectations:unmatch/404    Actual: panic
         // skippedPath: It can only be executed if the secondary route is not found
         skippedPath = ""
         continue walk
      }
      // Nothing found. We can recommend to redirect to the same URL with an
      // extra trailing slash if a leaf exists for that path
      value.tsr = path == "/" ||
         (len(prefix) == len(path)+1 && n.handlers != nil)
      return
   }
}
```
## 常见问题

### 如何自定义 Context

由于 gin.Context 不是一个接口，所以无法用继承的方式来直接用 CustomContext 替换，所以需要通过 gin.Context.Keys 来传递 CustomContext, 并通过一个路由包装方法来让控制器直接收到 CustomContext

1. 自定义一个 context 继承 *gin.Context
```go
type CustomContext struct {
   *gin.Context
   User *model.User
}

// 定义中间件
func WithContext() gin.HandlerFunc {
   return func(c *gin.Context) {
      c.Set("ctx", &CustomContext{
         Context: c,
      })
      c.Next()
   }
}
```
2. 封装一个方法，使其返回 gin.HandlerFunc
```go
type HandlerFunc func(ctx *CustomContext)

func Route(r HandlerFunc) gin.HandlerFunc {
	return func(c *gin.Context) {
		ctx := c.MustGet("ctx").(*CustomContext)
        // 运行控制器
        r(ctx)
        // 可以选择 ctx.Error(err) 的方式来传递错误
        if len(ctx.Errors) != 0 {
           c.AbortWithStatusJSON(http.StatusInternalServerError, ctx.Errors.JSON())
           return
        }
        return
	}
}
```
3. 使用中间件，定义路由
```go
func main() {
  r := gin.New()
  r.Use(WithContext())
  r.GET("test", Route(Test))
  r.Run()
}

// 控制器可以直接使用 CustomContext
func Test(ctx *CustomContext) {
  ctx.String(http.StatusOK, ctx.User.ID)
}
```
4. 调用接口
```go
curl http://127.0.0.1:8080/test

ok
```

### 
### Context.Copy() 后能得知请求超时吗？

**先说结论:**

1. **可以得知，因为 gin.Context.Request.Context 没有改变**
2. **如果需要在超时时立即得到超时消息，需要借助 http.TimeoutHandler() 来设置请求超时时间。http.Server.*Timeout 均会在请求处理完成后才会得知消息。**
我们观察 gin.Context 的代码，可以看到有以下方法:

```go
/************************************/
/***** GOLANG.ORG/X/NET/CONTEXT *****/
/************************************/
// Deadline returns that there is no deadline (ok==false) when c.Request has no Context.
func (c *Context) Deadline() (deadline time.Time, ok bool) {
   if c.Request == nil || c.Request.Context() == nil {
      return
   }
   return c.Request.Context().Deadline()
}
// Done returns nil (chan which will wait forever) when c.Request has no Context.
func (c *Context) Done() <-chan struct{} {
   if c.Request == nil || c.Request.Context() == nil {
      return nil
   }
   return c.Request.Context().Done()
}
// Err returns nil when c.Request has no Context.
func (c *Context) Err() error {
   if c.Request == nil || c.Request.Context() == nil {
      return nil
   }
   return c.Request.Context().Err()
}
// Value returns the value associated with this context for key, or nil
// if no value is associated with key. Successive calls to Value with
// the same key returns the same result.
func (c *Context) Value(key interface{}) interface{} {
   if key == 0 {
      return c.Request
   }
   if keyAsString, ok := key.(string); ok {
      if val, exists := c.Get(keyAsString); exists {
         return val
      }
   }
   if c.Request == nil || c.Request.Context() == nil {
      return nil
   }
   return c.Request.Context().Value(key)
}
```
可以发现实现的 context.Context 接口实际上是用的 Reqeust.Context，而 gin.Context.Copy() 时 Reqeust 是没有变化的，所以 Request.Context 上下文是相同的。
另外，默认的 http.Server 超时配置项 WriteTimeout 只能使 Request.Context().Done() 得到 write close 消息，会在**请求处理完后**才得知消息，故需要 http.TimeoutHandler 方法来实现请求超时立即得到消息的功能。

下面举例一个在请求处理超时时，中断协程中的任务的示例:

```go


func TestTimeout(t *testing.T) {
   r := New()
   r.GET("/test", func(c *Context) {
      // 执行一个异步耗时任务
      go func(c2 *Context) {
         rd := rand.Intn(5)
         select {
         case <-c2.Request.Context().Done():
            log.Printf("任务执行了 %ds, 已经超时了: %s\n", rd, c2.Request.Context().Err().Error())
         case <-time.After(time.Duration(rd) * time.Second):
            log.Printf("任务执行完成，耗时 %ds", rd)
         }
      }(c.Copy())
      log.Println("receive")
      // 另一个同步耗时任务，确保请求必定超时，使协程中收到超时消息
      time.Sleep(5 * time.Second)
      log.Println("end")
      fmt.Println()
      c.String(http.StatusOK, "ok")
   })
   s := &http.Server{
      Handler:      http.TimeoutHandler(r, 3*time.Second, "timeout!"),
      WriteTimeout: 10 * time.Second,
      Addr:         ":8080",
   }
   if err := s.ListenAndServe(); err != nil {
      panic(err)
   }
} 
```
调用接口多次，可以看到当任务执行时间 > 3s 时，Reqeust.Context().Done() 会收到 context deadline exceeded 消息，可以选择中断正在执行的异步任务。
![图片](data:image/png;base64,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)

