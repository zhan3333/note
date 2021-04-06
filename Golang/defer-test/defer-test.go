package main

import "fmt"

// 函数的返回函数的执行是优先于 defer 的, 因为返回值的计算属于函数执行的一部分, 而 defer 属于函数结束后再执行的一部分
//
// 执行结果
// f1
// f2
// defer

func main() {
	f1()
}

func f1() bool {
	defer func() {
		fmt.Println("defer")
	}()
	fmt.Println("f1")
	return func() bool {
		fmt.Println("f2")
		return true
	}()
}
