package main

import (
	"errors"
	"fmt"
	"sync"
)

type CircularQueue struct {
	size  int
	head  int
	tail  int
	items []interface{}
	mu    sync.Mutex
}

func New(s int) *CircularQueue {
	cq := &CircularQueue{
		size:  s,
		head:  -1,
		tail:  -1,
		items: make([]interface{}, s),
	}
	return cq
}

func (cq *CircularQueue) GetHead() interface{} {
	return cq.items[cq.head]
}

func (cq *CircularQueue) IsFull() bool {
	if (cq.tail+1)%cq.size == cq.head {
		return true
	}
	return false
}

func (cq *CircularQueue) IsEmpty() bool {
	if cq.head == -1 && cq.tail == -1 {
		return true
	}
	return false
}
func (cq *CircularQueue) EnQueue(i interface{}) bool {
	cq.mu.Lock()
	defer cq.mu.Unlock()
	if cq.IsFull() {
		return false
	}

	if cq.head == -1 {
		cq.head = 0
		cq.tail = 0
	} else {
		cq.tail = (cq.tail + 1) % cq.size
	}
	cq.items[cq.tail] = i
	return true
}

func (cq *CircularQueue) DeQueue() (interface{}, error) {
	cq.mu.Lock()
	defer cq.mu.Unlock()
	if cq.IsEmpty() {
		return nil, errors.New("queue is empty")
	}
	i := cq.items[cq.head]

	if cq.head == cq.tail {
		cq.head = -1
		cq.tail = -1
	} else {
		cq.head = (cq.head + 1) % cq.size
	}
	return i, nil
}

func main() {
	q := New(10)
	fmt.Println(q.IsEmpty())
	fmt.Println(q.IsFull())
	ret := q.EnQueue(1)
	fmt.Println(ret)
	i, err := q.DeQueue()
	fmt.Println(i ,err)
}
