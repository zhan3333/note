package tree

func isSymmetric(root *TreeNode) bool {
	if root == nil {
		return true
	}
	return helper(root.Left, root.Right)
}

func helper(t1 *TreeNode, t2 *TreeNode) bool {
	if t1 == nil && t2 == nil {
		return true
	}
	if t1 == nil || t2 == nil {
		return false
	}
	return t1.Val == t2.Val && helper(t1.Left, t2.Right) && helper(t1.Right, t2.Left)
}

func isSymmetric2(root *TreeNode) bool {
	// 层序遍历
	if root == nil {
		return true
	}
	stack := []*TreeNode{root}
	for len(stack) > 0 {
		l := len(stack)
		for i := 0; i < l; i++ {
			j := l - i - 1 // 对称位置
			if stack[i] == nil && stack[j] == nil {
				continue
			} else if stack[i] == nil || stack[j] == nil {
				return false
			} else if stack[i].Val != stack[j].Val {
				return false
			} else {
				stack = append(stack, stack[i].Left)
				stack = append(stack, stack[i].Right)
			}
		}
		stack = stack[l:]
	}
	return true
}
