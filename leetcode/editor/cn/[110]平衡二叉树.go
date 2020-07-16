package leetcode_golang

import "math"

//给定一个二叉树，判断它是否是高度平衡的二叉树。 
//
// 本题中，一棵高度平衡二叉树定义为： 
//
// 
// 一个二叉树每个节点 的左右两个子树的高度差的绝对值不超过1。 
// 
//
// 示例 1: 
//
// 给定二叉树 [3,9,20,null,null,15,7] 
//
//     3
//   / \
//  9  20
//    /  \
//   15   7 
//
// 返回 true 。 
// 
//示例 2: 
//
// 给定二叉树 [1,2,2,3,3,null,null,4,4] 
//
//        1
//      / \
//     2   2
//    / \
//   3   3
//  / \
// 4   4
// 
//
// 返回 false 。 
//
// 
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
func isBalanced(root *TreeNode) bool {
	b, _ := isBalancedHelper(root)
	return b
}

func isBalancedHelper(node *TreeNode) (bool, int) {
	if node == nil {
		return true, 0
	}
	if node.Left == nil && node.Right == nil {
		return true, 1
	}
	l, ld := isBalancedHelper(node.Left)
	r, rd := isBalancedHelper(node.Right)
	return math.Abs(float64(ld-rd)) <= 1 && l && r, int(math.Max(float64(ld), float64(rd))) + 1
}

//leetcode submit region end(Prohibit modification and deletion)
