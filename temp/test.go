package main

import "fmt"

func main() {
	arr := []int{1, 2}
	fmt.Printf("%+v \n", arr[0:0])
	fmt.Printf("%+v \n", arr[1:])
	fmt.Printf("%+v \n", arr[:])
	fmt.Printf("%+v", fmt.Errorf("test"))
}
