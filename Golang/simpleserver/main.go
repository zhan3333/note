package main

import (
	"fmt"
	"net/http"
	"os"
	"sync"
)

func HelloHandler(w http.ResponseWriter, r *http.Request) {
	fmt.Println(r.Method)
	_, _ = fmt.Fprintf(w, "Hello World")
}


func main() {
	var wg = sync.WaitGroup{}
	http.HandleFunc("/", HelloHandler)
	wg.Add(1)
	go func() {
		defer wg.Done()
		fmt.Println("8000 start")
		if err := http.ListenAndServe(":8000", nil); err != nil {
			panic(err)
		}
	}()
	wg.Add(1)
	go func() {
		defer wg.Done()
		fmt.Println("8001 start")
		if err := http.ListenAndServe(":8001", nil); err != nil {
			panic(err)
		}
	}()
	fmt.Printf("当前进程 pid: %d\n", os.Getpid())
	wg.Wait()
}
