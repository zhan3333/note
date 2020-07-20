package leetcode_golang

import "math"

//设计一个支持 push ，pop ，top 操作，并能在常数时间内检索到最小元素的栈。 
//
// 
// push(x) —— 将元素 x 推入栈中。 
// pop() —— 删除栈顶的元素。 
// top() —— 获取栈顶元素。 
// getMin() —— 检索栈中的最小元素。 
// 
//
// 
//
// 示例: 
//
// 输入：
//["MinStack","push","push","push","getMin","pop","top","getMin"]
//[[],[-2],[0],[-3],[],[],[],[]]
//
//输出：
//[null,null,null,null,-3,null,0,-2]
//
//解释：
//MinStack minStack = new MinStack();
//minStack.push(-2);
//minStack.push(0);
//minStack.push(-3);
//minStack.getMin();   --> 返回 -3.
//minStack.pop();
//minStack.top();      --> 返回 0.
//minStack.getMin();   --> 返回 -2.
// 
//
// 
//
// 提示： 
//
// 
// pop、top 和 getMin 操作总是在 非空栈 上调用。 
// 
// Related Topics 栈 设计 
// 👍 610 👎 0

//leetcode submit region begin(Prohibit modification and deletion)
type MinStack struct {
	Nodes []*Node
}

type Node struct {
	Min int
	Val int
}

/** initialize your data structure here. */
func Constructor() MinStack {
	return MinStack{}
}

func (this *MinStack) Push(x int) {
	var min int
	if len(this.Nodes) == 0 {
		min = x
	} else {
		min = int(math.Min(float64(this.Nodes[len(this.Nodes)-1].Min), float64(x)))
	}
	this.Nodes = append(this.Nodes, &Node{
		Min: min,
		Val: x,
	})
}

func (this *MinStack) Pop() {
	if len(this.Nodes) > 0 {
		this.Nodes = this.Nodes[0 : len(this.Nodes)-1]
	}
}

func (this *MinStack) Top() int {
	if len(this.Nodes) > 0 {
		return this.Nodes[len(this.Nodes)-1].Val
	}
	return 0
}

func (this *MinStack) GetMin() int {
	if len(this.Nodes) > 0 {
		return this.Nodes[len(this.Nodes)-1].Min
	}
	return 0
}

/**
 * Your MinStack object will be instantiated and called as such:
 * obj := Constructor();
 * obj.Push(x);
 * obj.Pop();
 * param_3 := obj.Top();
 * param_4 := obj.GetMin();
 */
//leetcode submit region end(Prohibit modification and deletion)
