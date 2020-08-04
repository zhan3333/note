package leetcode_golang

//使用队列实现栈的下列操作： 
//
// 
// push(x) -- 元素 x 入栈 
// pop() -- 移除栈顶元素 
// top() -- 获取栈顶元素 
// empty() -- 返回栈是否为空 
// 
//
// 注意: 
//
// 
// 你只能使用队列的基本操作-- 也就是 push to back, peek/pop from front, size, 和 is empty 这些操作是合
//法的。 
// 你所使用的语言也许不支持队列。 你可以使用 list 或者 deque（双端队列）来模拟一个队列 , 只要是标准的队列操作即可。 
// 你可以假设所有操作都是有效的（例如, 对一个空的栈不会调用 pop 或者 top 操作）。 
// 
// Related Topics 栈 设计

//leetcode submit region begin(Prohibit modification and deletion)
type MyStack struct {
	Queue1 Queue
	Queue2 Queue
}

type Queue struct {
	Items []int
}

func (q *Queue) Push(x int) {
	q.Items = append(q.Items, x)
}

func (q *Queue) Pop() int {
	item := q.Items[0]
	q.Items = q.Items[1:len(q.Items)]
	return item
}

func (q *Queue) Top() int {
	return q.Items[0]
}

func (q *Queue) Size() int {
	return len(q.Items)
}

/** Initialize your data structure here. */
func Constructor() MyStack {
	return MyStack{}
}

/** Push element x onto stack. */
func (this *MyStack) Push(x int) {
	this.Queue1.Push(x)
}

/** Removes the element on top of the stack and returns that element. */
func (this *MyStack) Pop() int {
	for this.Queue1.Size() > 1 {
		this.Queue2.Push(this.Queue1.Pop())
	}
	pop := this.Queue1.Pop()
	t := this.Queue1
	this.Queue1 = this.Queue2
	this.Queue2 = t
	return pop
}

/** Get the top element. */
func (this *MyStack) Top() int {
	top := this.Pop()
	this.Queue1.Push(top)
	return top
}

/** Returns whether the stack is empty. */
func (this *MyStack) Empty() bool {
	return this.Queue1.Size() == 0
}

/**
 * Your MyStack object will be instantiated and called as such:
 * obj := Constructor();
 * obj.Push(x);
 * param_2 := obj.Pop();
 * param_3 := obj.Top();
 * param_4 := obj.Empty();
 */
//leetcode submit region end(Prohibit modification and deletion)
