package leetcode_golang

//使用栈实现队列的下列操作： 
//
// 
// push(x) -- 将一个元素放入队列的尾部。 
// pop() -- 从队列首部移除元素。 
// peek() -- 返回队列首部的元素。 
// empty() -- 返回队列是否为空。 
// 
//
// 
//
// 示例: 
//
// MyQueue queue = new MyQueue();
//
//queue.push(1);
//queue.push(2);  
//queue.peek();  // 返回 1
//queue.pop();   // 返回 1
//queue.empty(); // 返回 false 
//
// 
//
// 说明: 
//
// 
// 你只能使用标准的栈操作 -- 也就是只有 push to top, peek/pop from top, size, 和 is empty 操作是合法的。
// 
// 你所使用的语言也许不支持栈。你可以使用 list 或者 deque（双端队列）来模拟一个栈，只要是标准的栈操作即可。 
// 假设所有操作都是有效的 （例如，一个空的队列不会调用 pop 或者 peek 操作）。 
// 
// Related Topics 栈 设计

//leetcode submit region begin(Prohibit modification and deletion)
type MyQueue struct {
	Stack1 Stack
	Stack2 Stack
}

type Stack struct {
	Items []int
}

func (s *Stack) Push(x int) {
	s.Items = append(s.Items, x)
}

func (s *Stack) Pop() int {
	pop := s.Items[len(s.Items)-1]
	s.Items = s.Items[0 : len(s.Items)-1]
	return pop
}

func (s *Stack) Empty() bool {
	return len(s.Items) == 0
}

func (s *Stack) Peek() int {
	return s.Items[len(s.Items)-1]
}

/** Initialize your data structure here. */
func Constructor() MyQueue {
	return MyQueue{}
}

/** Push element x to the back of queue. */
func (this *MyQueue) Push(x int) {
	this.Stack1.Push(x)
}

/** Removes the element from in front of queue and returns that element. */
func (this *MyQueue) Pop() int {
	if this.Stack2.Empty() {
		for !this.Stack1.Empty() {
			this.Stack2.Push(this.Stack1.Pop())
		}
	}

	return this.Stack2.Pop()
}

/** Get the front element. */
func (this *MyQueue) Peek() int {
	if this.Stack2.Empty() {
		for !this.Stack1.Empty() {
			this.Stack2.Push(this.Stack1.Pop())
		}
	}
	return this.Stack2.Peek()
}

/** Returns whether the queue is empty. */
func (this *MyQueue) Empty() bool {
	return this.Stack1.Empty() && this.Stack2.Empty()
}

/**
 * Your MyQueue object will be instantiated and called as such:
 * obj := Constructor();
 * obj.Push(x);
 * param_2 := obj.Pop();
 * param_3 := obj.Peek();
 * param_4 := obj.Empty();
 */
//leetcode submit region end(Prohibit modification and deletion)
