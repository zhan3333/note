package tree

import "math"

func minDepth(root *TreeNode) int {
	if root == nil {
		return 0
	}
	// left 不参与比较
	if root.Left == nil && root.Right != nil {
		return 1 + minDepth(root.Right)
	}
	// right 不参与比较
	if root.Left != nil && root.Right == nil {
		return 1 + minDepth(root.Left)
	}
	return int(math.Min(float64(minDepth(root.Left)), float64(minDepth(root.Right)))) + 1
}
