package leetcode_golang

import "math"

//请设计一个栈，除了常规栈支持的pop与push函数以外，还支持min函数，该函数返回栈元素中的最小值。执行push、pop和min操作的时间复杂度必须为O(
//1)。 示例： MinStack minStack = new MinStack(); minStack.push(-2); minStack.push(0);
// minStack.push(-3); minStack.getMin();   --> 返回 -3. minStack.pop(); minStack.top
//();      --> 返回 0. minStack.getMin();   --> 返回 -2. Related Topics 栈

//leetcode submit region begin(Prohibit modification and deletion)
type MinStack struct {
	Items []Item
}

type Item struct {
	Val int
	Min int
}

/** initialize your data structure here. */
func Constructor() MinStack {
	return MinStack{}
}

func (this *MinStack) Push(x int) {
	m := x
	if len(this.Items) > 0 {
		m = min(x, this.Items[len(this.Items)-1].Min)
	}
	this.Items = append(this.Items, Item{
		Val: x,
		Min: m,
	})
}

func (this *MinStack) Pop() {
	this.Items = this.Items[0 : len(this.Items)-1]
}

func (this *MinStack) Top() int {
	return this.Items[len(this.Items)-1].Val
}

func (this *MinStack) GetMin() int {
	return this.Items[len(this.Items)-1].Min
}

func min(a, b int) int {
	return int(math.Min(float64(a), float64(b)))
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
