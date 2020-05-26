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

func maxDepth2(root *TreeNode) int {
	// 深度优先遍历
	max := 0
	type s struct {
		Depth int
		Root  *TreeNode
	}
	stack := []s{
		{
			Depth: 0,
			Root:  root,
		},
	}
	for len(stack) > 0 {
		node := stack[len(stack)-1]
		stack = stack[:len(stack)-1]
		if node.Root != nil {
			max = int(math.Max(float64(node.Depth+1), float64(max)))
			if node.Root.Right != nil {
				stack = append(stack, s{
					Depth: node.Depth + 1,
					Root:  node.Root.Right,
				})
			}
			if node.Root.Left != nil {
				stack = append(stack, s{
					Depth: node.Depth + 1,
					Root:  node.Root.Left,
				})
			}
		}
	}
	return max
}
