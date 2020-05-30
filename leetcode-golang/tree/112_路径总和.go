package tree

func hasPathSum(root *TreeNode, sum int) bool {
	if root == nil {
		return false
	}
	type t struct {
		Node *TreeNode
		Sum  int
	}
	stack := []t{
		{
			Node: root,
			Sum:  root.Val,
		},
	}
	for len(stack) > 0 {
		n := stack[len(stack)-1]
		stack = stack[:len(stack)-1]
		if n.Node.Left == nil && n.Node.Right == nil && n.Sum == sum {
			return true
		}
		if n.Node.Right != nil {
			stack = append(stack, t{
				Node: n.Node.Right,
				Sum:  n.Sum + n.Node.Right.Val,
			})
		}
		if n.Node.Left != nil {
			stack = append(stack, t{
				Node: n.Node.Left,
				Sum:  n.Sum + n.Node.Left.Val,
			})
		}
	}
	return false
}
