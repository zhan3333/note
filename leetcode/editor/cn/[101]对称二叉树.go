package leetcode_golang

//给定一个二叉树，检查它是否是镜像对称的。 
//
// 
//
// 例如，二叉树 [1,2,2,3,4,4,3] 是对称的。 
//
//     1
//   / \
//  2   2
// / \ / \
//3  4 4  3
// 
//
// 
//
// 但是下面这个 [1,2,2,null,3,null,3] 则不是镜像对称的: 
//
//     1
//   / \
//  2   2
//   \   \
//   3    3
// 
//
// 
//
// 进阶： 
//
// 你可以运用递归和迭代两种方法解决这个问题吗？ 
// Related Topics 树 深度优先搜索 广度优先搜索

//leetcode submit region begin(Prohibit modification and deletion)
/**
 * Definition for a binary tree node.
 * type TreeNode struct {
 *     Val int
 *     Left *TreeNode
 *     Right *TreeNode
 * }
 */
func isSymmetric(root *TreeNode) bool {
	stack := []*TreeNode{root}
	for len(stack) != 0 {
		g := stack[0:]
		stack = []*TreeNode{}
		// 检查这一层的数据
		for i := 0; i < len(g); i++ {
			node := g[i]
			if node != nil {
				if g[len(g)-i-1] == nil || g[len(g)-i-1].Val != node.Val {
					return false
				}
				stack = append(stack, node.Left)
				stack = append(stack, node.Right)
			} else {
				if g[len(g)-i-1] != nil {
					return false
				}
			}
		}
	}
	return true
}

func isSymmetric2(root *TreeNode) bool {
	if root == nil {
		return true
	}
	return isSame(root.Left, root.Right)
}

func isSame(l *TreeNode, r *TreeNode) bool {
	if l == nil && r == nil {
		return true
	}
	if l == nil || r == nil {
		return false
	}
	return l.Val == r.Val && isSame(l.Left, r.Right) && isSame(l.Right, r.Left)
}

//leetcode submit region end(Prohibit modification and deletion)
