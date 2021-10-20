# gin 源码分析

https://github.com/gin-gonic/gin

分析完源码，可以看到一个 http 框架主要需要实现的功能:

1. 请求响应上下文传递
2. 请求解析，响应构建
3. 路由定义，请求查询定义好的路由
4. 路由指定中间件

我们可以实现一个类似的框架

## 分析

先看例子:

```
package main

import "github.com/gin-gonic/gin"

func main() {
	r := gin.Default()
	r.GET("/ping", func(c *gin.Context) {
		c.JSON(200, gin.H{
			"message": "pong",
		})
	})
	r.Run() // listen and serve on 0.0.0.0:8080 (for windows "localhost:8080")
}
```

看 gin.Default()

```
func Default() *Engine {
    // 检查当前 golang 版本，< 13 会输出警告到控制台
	debugPrintWARNINGDefault()
    // 创建 Engine
	engine := New()
    // 使用中间件
	engine.Use(Logger(), Recovery())
	return engine
}
```

看 New()

```
func New() *Engine {
    // 在 debug mode 会输出一下提示 
	debugPrintWARNINGNew()
	engine := &Engine{
        // 路由
		RouterGroup: RouterGroup{
			Handlers: nil,
			basePath: "/",
			root:     true,
		},
		FuncMap:                template.FuncMap{},
		RedirectTrailingSlash:  true,
		RedirectFixedPath:      false,
		HandleMethodNotAllowed: false,
		ForwardedByClientIP:    true,
		RemoteIPHeaders:        []string{"X-Forwarded-For", "X-Real-IP"},
		TrustedPlatform:        defaultPlatform,
		UseRawPath:             false,
		RemoveExtraSlash:       false,
		UnescapePathValues:     true,
		MaxMultipartMemory:     defaultMultipartMemory,
        // 路由树，路由不同的 http method 会分在不同的树上 
		trees:                  make(methodTrees, 0, 9),
		delims:                 render.Delims{Left: "{{", Right: "}}"},
		secureJSONPrefix:       "while(1);",
		trustedProxies:         []string{"0.0.0.0/0"},
		trustedCIDRs:           defaultTrustedCIDRs,
	}
	engine.RouterGroup.engine = engine
    // pool 减少 请求上下文 context 创建的性能损耗 
	engine.pool.New = func() interface{} {
		return engine.allocateContext()
	}
	return engine
}
```

看 engine.Run() 怎么运行起来的服务

```
// 调用后会一直阻塞，直到内部有错误发生
func (engine *Engine) Run(addr ...string) (err error) {
    // 发生错误时，如果在 debug mode，则输出 err 到控制台
	defer func() { debugPrintError(err) }()

    // context.RealIP() 时，会根据配置的 trustedProxies 返回 ip 是否是可靠的
    // 当配置了不安全的 信任 proxy 时，这里会给出警告
	if engine.isUnsafeTrustedProxies() {
		debugPrint("[WARNING] You trusted all proxies, this is NOT safe. We recommend you to set a value.\n" +
			"Please check https://pkg.go.dev/github.com/gin-gonic/gin#readme-don-t-trust-all-proxies for details.")
	}

	address := resolveAddress(addr)
	debugPrint("Listening and serving HTTP on %s\n", address)

    // 通过 http 启动 server
    // engine 实现了 http.Handler 接口
	err = http.ListenAndServe(address, engine)
	return
}
```

http.Handler
```
type Handler interface {
	ServeHTTP(ResponseWriter, *Request)
}
```

gin 实现的 http.Handler 接口: gin.ServeHTTP
```
func (engine *Engine) ServeHTTP(w http.ResponseWriter, req *http.Request) {
	c := engine.pool.Get().(*Context)
    // 清空 response
	c.writermem.reset(w)
    // 设置 request
	c.Request = req
    // context 做清理，防止上一次使用时的数据影响
	c.reset()

    // engine 开始处理请求
	engine.handleHTTPRequest(c)

    // context 放回到 pool 中
	engine.pool.Put(c)
}
```

engine.handleHTTPRequest

```
func (engine *Engine) handleHTTPRequest(c *Context) {
	httpMethod := c.Request.Method
	rPath := c.Request.URL.Path
	unescape := false
	if engine.UseRawPath && len(c.Request.URL.RawPath) > 0 {
		rPath = c.Request.URL.RawPath
		unescape = engine.UnescapePathValues
	}

    // 路径中多个 / 处理成单个 /
	if engine.RemoveExtraSlash {
		rPath = cleanPath(rPath)
	}

    // 使用 path 在 trees 中匹配路由
	// Find root of the tree for the given HTTP method
	t := engine.trees
	for i, tl := 0, len(t); i < tl; i++ {
		if t[i].method != httpMethod {
			continue
		}
		root := t[i].root
		// Find route in tree
		value := root.getValue(rPath, c.params, unescape)
		if value.params != nil {
			c.Params = *value.params
		}
		if value.handlers != nil {
			c.handlers = value.handlers
			c.fullPath = value.fullPath
			// 执行中间件
			c.Next()
			c.writermem.WriteHeaderNow()
			return
		}
		// /path/ 301 到 /path
		if httpMethod != http.MethodConnect && rPath != "/" {
			if value.tsr && engine.RedirectTrailingSlash {
				redirectTrailingSlash(c)
				return
			}
			if engine.RedirectFixedPath && redirectFixedPath(c, root, engine.RedirectFixedPath) {
				return
			}
		}
		break
	}

	// 如果有不被允许的 http method，则走下边逻辑
	// method not allow 时, 执行配置好的 NoMethod handles，响应 405 
	if engine.HandleMethodNotAllowed {
		for _, tree := range engine.trees {
			if tree.method == httpMethod {
				continue
			}
			if value := tree.root.getValue(rPath, nil, unescape); value.handlers != nil {
				c.handlers = engine.allNoMethod
				serveError(c, http.StatusMethodNotAllowed, default405Body)
				return
			}
		}
	}
	// 路由未找到的逻辑
	c.handlers = engine.allNoRoute
	serveError(c, http.StatusNotFound, default404Body)
}
```

看看 c.Next() 如何执行的;

代码很简单，context 中有个计数器 index 表示执行到了哪个 handler，一层层调用

```
func (c *Context) Next() {
	c.index++
	for c.index < int8(len(c.handlers)) {
		c.handlers[c.index](c)
		c.index++
	}
}
```

那么 c.handlers 从哪里来的呢？

是从 enginer.trees 查询到注册的控制器, getValue() 内部比较复杂，以后再分析。

```
value := root.getValue(rPath, c.params, unescape)
```

trees 如何注册路由进去的？
可以看 RouteGroup.GET() 为例:

```
// GET is a shortcut for router.Handle("GET", path, handle).
func (group *RouterGroup) GET(relativePath string, handlers ...HandlerFunc) IRoutes {
	return group.handle(http.MethodGet, relativePath, handlers)
}

func (group *RouterGroup) handle(httpMethod, relativePath string, handlers HandlersChain) IRoutes {
	// 拼接绝对路径, enginer 在初始化时可以配置 basePath
	absolutePath := group.calculateAbsolutePath(relativePath)
	// 合并全局中间件和路由中间件
	handlers = group.combineHandlers(handlers)
	group.engine.addRoute(httpMethod, absolutePath, handlers)
	return group.returnObj()
}

// 往 enginer.trees 中加入解析好的路由
func (engine *Engine) addRoute(method, path string, handlers HandlersChain) {
	assert1(path[0] == '/', "path must begin with '/'")
	assert1(method != "", "HTTP method can not be empty")
	assert1(len(handlers) > 0, "there must be at least one handler")

	debugPrintRoute(method, path, handlers)

	root := engine.trees.get(method)
	if root == nil {
		root = new(node)
		root.fullPath = "/"
		engine.trees = append(engine.trees, methodTree{method: method, root: root})
	}
	root.addRoute(path, handlers)

	// Update maxParams
	if paramsCount := countParams(path); paramsCount > engine.maxParams {
		engine.maxParams = paramsCount
	}
}
```

还有一个全局中间件 enginer.Use(): 

代码很简单，在 RouteGroup.Handlers slice 中加入传入的中间件

```
// Use adds middleware to the group, see example code in GitHub.
func (group *RouterGroup) Use(middleware ...HandlerFunc) IRoutes {
	group.Handlers = append(group.Handlers, middleware...)
	return group.returnObj()
}
```

附上中间件类型定义:
控制器也是属于这个类型，所以可以看作是路由中间件组的最后一环。

```
type HandlerFunc func(*Context)
```
