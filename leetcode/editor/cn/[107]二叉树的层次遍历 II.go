package leetcode_golang

//给定一个二叉树，返回其节点值自底向上的层次遍历。 （即按从叶子节点所在层到根节点所在的层，逐层从左向右遍历） 
//
// 例如： 
//给定二叉树 [3,9,20,null,null,15,7], 
//
//     3
//   / \
//  9  20
//    /  \
//   15   7
// 
//
// 返回其自底向上的层次遍历为： 
//
// [
//  [15,7],
//  [9,20],
//  [3]
//]
// 
// Related Topics 树 广度优先搜索

//leetcode submit region begin(Prohibit modification and deletion)
/**
 * Definition for a binary tree node.
 * type TreeNode struct {
 *     Val int
 *     Left *TreeNode
 *     Right *TreeNode
 * }
 */
func levelOrderBottom(root *TreeNode) [][]int {
	var ans [][]int
	if root == nil {
		return ans
	}
	queue := []*TreeNode{root}
	for len(queue) > 0 {
		g := queue[:]
		queue = []*TreeNode{}
		var a []int
		for _, i := range g {
			a = append(a, i.Val)
			if i.Left != nil {
				queue = append(queue, i.Left)
			}
			if i.Right != nil {
				queue = append(queue, i.Right)
			}
		}
		ans = append([][]int{a}, ans...)
	}
	return ans
}

//leetcode submit region end(Prohibit modification and deletion)
