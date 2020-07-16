package leetcode_golang

import "math"

//给定一个二叉树，找出其最大深度。 
//
// 二叉树的深度为根节点到最远叶子节点的最长路径上的节点数。 
//
// 说明: 叶子节点是指没有子节点的节点。 
//
// 示例： 
//给定二叉树 [3,9,20,null,null,15,7]， 
//
//     3
//   / \
//  9  20
//    /  \
//   15   7 
//
// 返回它的最大深度 3 。 
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
func maxDepth(root *TreeNode) int {
	type Item struct {
		Node  *TreeNode
		Depth int
	}
	queue := []Item{{
		Node:  root,
		Depth: 1,
	}}
	max := 0
	for len(queue) > 0 {
		item := queue[0]
		queue = queue[1:]
		if item.Node != nil {
			max = int(math.Max(float64(max), float64(item.Depth)))
			queue = append(queue, Item{
				Node:  item.Node.Left,
				Depth: item.Depth + 1,
			})
			queue = append(queue, Item{
				Node:  item.Node.Right,
				Depth: item.Depth + 1,
			})
		}
	}
	return max
}

//leetcode submit region end(Prohibit modification and deletion)
