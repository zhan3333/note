package leetcode_golang

import "strconv"

//给定一个二叉树，返回所有从根节点到叶子节点的路径。 
//
// 说明: 叶子节点是指没有子节点的节点。 
//
// 示例: 
//
// 输入:
//
//   1
// /   \
//2     3
// \
//  5
//
//输出: ["1->2->5", "1->3"]
//
//解释: 所有根节点到叶子节点的路径为: 1->2->5, 1->3 
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
func binaryTreePaths(root *TreeNode) []string {
	ans := []string{}
	if root == nil {
		return ans
	}
	type T struct {
		node *TreeNode
		path string
	}
	queue := []T{
		{
			node: root,
			path: strconv.Itoa(root.Val),
		},
	}
	for len(queue) > 0 {
		item := queue[0]
		queue = queue[1:]
		if item.node.Left == nil && item.node.Right == nil {
			ans = append(ans, item.path)
		}
		if item.node.Left != nil {
			queue = append(queue, T{
				node: item.node.Left,
				path: item.path + "->" + strconv.Itoa(item.node.Left.Val),
			})
		}
		if item.node.Right != nil {
			queue = append(queue, T{
				node: item.node.Right,
				path: item.path + "->" + strconv.Itoa(item.node.Right.Val),
			})
		}
	}
	return ans
}

//leetcode submit region end(Prohibit modification and deletion)
