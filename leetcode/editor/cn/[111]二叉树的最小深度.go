package leetcode_golang

//给定一个二叉树，找出其最小深度。
//
// 最小深度是从根节点到最近叶子节点的最短路径上的节点数量。 
//
// 说明: 叶子节点是指没有子节点的节点。 
//
// 示例: 
//
// 给定二叉树 [3,9,20,null,null,15,7], 
//
//     3
//   / \
//  9  20
//    /  \
//   15   7 
//
// 返回它的最小深度 2. 
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
func minDepth(root *TreeNode) int {
	if root == nil {
		return 0
	}
	type T struct {
		node  *TreeNode
		depth int
	}
	queue := []T{{
		node:  root,
		depth: 1,
	}}
	for len(queue) != 0 {
		g := queue[:]
		queue = []T{}
		b := []int{}
		for _, a := range g {
			b = append(b, a.node.Val)
		}
		for _, a := range g {
			if a.node.Left == nil && a.node.Right == nil {
				// 第一个叶子节点就是最小深度
				return a.depth
			}
			if a.node.Left != nil {
				queue = append(queue, T{
					node:  a.node.Left,
					depth: a.depth + 1,
				})
			}
			if a.node.Right != nil {
				queue = append(queue, T{
					node:  a.node.Right,
					depth: a.depth + 1,
				})
			}
		}
	}
	return -1
}

//leetcode submit region end(Prohibit modification and deletion)
