package leetcode_golang

//给定一个非负索引 k，其中 k ≤ 33，返回杨辉三角的第 k 行。
//
// 
//
// 在杨辉三角中，每个数是它左上方和右上方的数的和。 
//
// 示例: 
//
// 输入: 3
//输出: [1,3,3,1]
// 
//
// 进阶： 
//
// 你可以优化你的算法到 O(k) 空间复杂度吗？ 
// Related Topics 数组

//leetcode submit region begin(Prohibit modification and deletion)
func getRow(rowIndex int) []int {
	tree := [][]int{}
	for i := 0; i <= rowIndex; i++ {
		t := []int{}
		for j := 0; j <= i; j++ {
			if j == 0 || j == i {
				t = append(t, 1)
			} else {
				t = append(t, tree[i-1][j-1]+tree[i-1][j])
			}
		}
		tree = append(tree, t)
	}
	return tree[rowIndex]
}

//leetcode submit region end(Prohibit modification and deletion)
