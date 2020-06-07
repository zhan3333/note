package stack

type MinStack struct {
	Nodes []Node
}

type Node struct {
	Val int
	Min int
}


/** initialize your data structure here. */
func Constructor() MinStack {
	return MinStack{
		Nodes: []Node{},
	}
}


func (this *MinStack) Push(x int)  {
	var node Node
	node.Val = x
	if len(this.Nodes) == 0 {
		node.Min = x
	} else {
		node.Min = int(math.Min(float64(this.Nodes[len(this.Nodes) - 1].Min), float64(x)))
	}
	this.Nodes = append(this.Nodes, node)
}


func (this *MinStack) Pop()  {
	if len(this.Nodes) > 0 {
		this.Nodes = this.Nodes[:len(this.Nodes)-1]
	}
}


func (this *MinStack) Top() int {
	if len(this.Nodes) == 0 {
		return 0
	}
	return this.Nodes[len(this.Nodes)-1].Val
}


func (this *MinStack) GetMin() int {
	if len(this.Nodes) == 0 {
		return 0
	}
	return this.Nodes[len(this.Nodes)-1].Min
}


/**
 * Your MinStack object will be instantiated and called as such:
 * obj := Constructor();
 * obj.Push(x);
 * obj.Pop();
 * param_3 := obj.Top();
 * param_4 := obj.GetMin();
 */