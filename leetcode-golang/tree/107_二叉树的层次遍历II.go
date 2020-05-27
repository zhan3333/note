package tree

func levelOrderBottom(root *TreeNode) [][]int {
	var ans [][]int
	if root == nil {
		return ans
	}
	queue := []*TreeNode{root}
	for len(queue) > 0 {
		l := len(queue)
		var levelData []int
		for i := 0; i < l; i++ {
			node := queue[0]
			queue = queue[1:]
			levelData = append(levelData, node.Val)
			if node.Left != nil {
				queue = append(queue, node.Left)
			}
			if node.Right != nil {
				queue = append(queue, node.Right)
			}
		}
		ans = append([][]int{levelData}, ans...)
	}
	return ans
}
