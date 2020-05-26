package tree

import "math"

func maxDepth(root *TreeNode) int {
	// 终止条件
	if root == nil {
		return 0
	}
	if root.Left == nil && root.Right == nil {
		return 1
	}
	// 返回 max(left, right) + 1, 为当前层的最高层数
	return int(math.Max(float64(maxDepth(root.Left)), float64(maxDepth(root.Right)))) + 1
}
