package tree

func isSameTree(p *TreeNode, q *TreeNode) bool {
	// 结束条件
	if p == nil && q == nil {
		return true
	} else if p == nil || q == nil {
		return false
	} else {
		return p.Val == q.Val && isSameTree(p.Left, q.Left) && isSameTree(p.Right, q.Right)
	}
}

// 非递归
func isSameTree2(p *TreeNode, q *TreeNode) bool {
	// 层序遍历
	type s struct {
		p1 *TreeNode
		p2 *TreeNode
	}
	stack := []s{
		{
			p1: p,
			p2: q,
		},
	}
	for len(stack) > 0 {
		newStack := stack[:]
		stack = []s{}
		for i := 0; i < len(newStack); i++ {
			if newStack[i].p1 == nil && newStack[i].p2 == nil {
				continue
			} else if newStack[i].p1 != nil || newStack[i].p2 != nil {
				return false
			} else if newStack[i].p1.Val != newStack[i].p2.Val {
				return false
			} else {
				stack = append(stack, s{
					p1: stack[i].p1.Left,
					p2: stack[i].p2.Left,
				})
				stack = append(stack, s{
					p1: stack[i].p1.Right,
					p2: stack[i].p2.Right,
				})
			}
		}
	}
	return true
}
