package leetcode_golang

//给定一个二叉树和一个目标和，判断该树中是否存在根节点到叶子节点的路径，这条路径上所有节点值相加等于目标和。 
//
// 说明: 叶子节点是指没有子节点的节点。 
//
// 示例: 
//给定如下二叉树，以及目标和 sum = 22， 
//
//               5
//             / \
//            4   8
//           /   / \
//          11  13  4
//         /  \      \
//        7    2      1
// 
//
// 返回 true, 因为存在目标和为 22 的根节点到叶子节点的路径 5->4->11->2。 
// Related Topics 树 深度优先搜索

//leetcode submit region begin(Prohibit modification and deletion)
/**
 * Definition for a binary tree node.
 * type TreeNode struct {
 *     Val int
 *     Left *TreeNode
 *     Right *TreeNode
 * }
 */
func hasPathSum(root *TreeNode, sum int) bool {
	if root == nil {
		return false
	}
	type T struct {
		node *TreeNode
		sum  int
	}
	queue := []T{
		{
			node: root,
			sum:  root.Val,
		},
	}
	for len(queue) > 0 {
		g := queue[:]
		queue = []T{}
		for _, i := range g {
			if i.node.Left == nil && i.node.Right == nil && i.sum == sum {
				return true
			}
			if i.node.Left != nil {
				queue = append(queue, T{
					node: i.node.Left,
					sum:  i.node.Left.Val + i.sum,
				})
			}
			if i.node.Right != nil {
				queue = append(queue, T{
					node: i.node.Right,
					sum:  i.node.Right.Val + i.sum,
				})
			}
		}
	}
	return false
}

//leetcode submit region end(Prohibit modification and deletion)
