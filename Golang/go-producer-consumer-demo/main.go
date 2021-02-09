package main

import (
	"context"
	"fmt"
	"os"
	"os/signal"
	"sync"
	"syscall"
	"time"
)

var ch = make(chan string, 10)

func producer(ctx context.Context, wg *sync.WaitGroup, i int) {
	defer func() {
		fmt.Printf("producer %d exit\n", i)
		wg.Done()
	}()
	fmt.Printf("producer %d start\n", i)
	for {
		select {
		case <-ctx.Done():
			return
		default:
			ch <- fmt.Sprintf("now time is: %s", time.Now().Format("15:04:05"))
			time.Sleep(time.Second * 1)
		}
	}
}

func worker(ctx context.Context, wg *sync.WaitGroup, i int) {
	defer func(i int) {
		fmt.Printf("worker %d exit\n", i)
		wg.Done()
	}(i)
	fmt.Printf("worker %d start\n", i)
	for {
		select {
		case <-ctx.Done():
			return
		case msg := <-ch:
			fmt.Printf("worker %d receive: %s\n", i, msg)
		}
	}
}

func main() {
	ctx, cancel := context.WithCancel(context.Background())
	wg := sync.WaitGroup{}
	// 启动消费者
	for i := 0; i < 4; i++ {
		wg.Add(1)
		go worker(ctx, &wg, i+1)
	}
	// 启动生产者
	wg.Add(1)
	go producer(ctx, &wg, 1)

	// 监听终止信号
	go func() {
		signChan := make(chan os.Signal)
		signal.Notify(signChan)
		for sign := range signChan {
			fmt.Printf("接收到信号: %s\n", sign)
			switch sign {
			case syscall.SIGINT, syscall.SIGHUP, syscall.SIGTERM:
				fmt.Println("开始退出")
				fmt.Println("发出清理信号")
				cancel()
			}
		}
	}()
	wg.Wait()
	fmt.Println("主程序退出")
}
