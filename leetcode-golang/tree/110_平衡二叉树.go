package tree

import "math"

func isBalanced(root *TreeNode) bool {
	if root == nil {
		return true
	}
	queue := []*TreeNode{root}
	for len(queue) > 0 {
		shift := queue[0]
		queue = queue[1:]
		if math.Abs(float64(height(shift.Left)-height(shift.Right))) > 1 {
			return false
		}
		if shift.Left != nil {
			queue = append(queue, shift.Left)
		}
		if shift.Right != nil {
			queue = append(queue, shift.Right)
		}
	}
	return true
}

func height(node *TreeNode) int {
	if node == nil {
		return 0
	}
	return int(math.Max(float64(height(node.Left)), float64(height(node.Right)))) + 1
}
