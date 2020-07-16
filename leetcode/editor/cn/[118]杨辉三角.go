package leetcode_golang

//给定一个非负整数 numRows，生成杨辉三角的前 numRows 行。 
//
// 
//
// 在杨辉三角中，每个数是它左上方和右上方的数的和。 
//
// 示例: 
//
// 输入: 5
//输出:
//[
//     [1],
//    [1,1],
//   [1,2,1],
//  [1,3,3,1],
// [1,4,6,4,1]
//] 
// Related Topics 数组

//leetcode submit region begin(Prohibit modification and deletion)
func generate(numRows int) [][]int {
	ans := [][]int{}
	for i := 0; i < numRows; i++ {
		// 当前行的数据
		t := []int{}
		for j := 0; j <= i; j++ {
			if j == 0 || j == i {
				t = append(t, 1)
			} else {
				t = append(t, ans[i-1][j-1]+ans[i-1][j])
			}
		}
		ans = append(ans, t)
	}
	return ans
}

//leetcode submit region end(Prohibit modification and deletion)
