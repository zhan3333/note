package leetcode_golang

//给定一个 没有重复 数字的序列，返回其所有可能的全排列。
//
// 示例: 
//
// 输入: [1,2,3]
//输出:
//[
//  [1,2,3],
//  [1,3,2],
//  [2,1,3],
//  [2,3,1],
//  [3,1,2],
//  [3,2,1]
//] 
// Related Topics 回溯算法

//leetcode submit region begin(Prohibit modification and deletion)
func permute(nums []int) [][]int {
	var ans [][]int
	var used = make([]bool, len(nums))
	var path = make([]int, len(nums))
	backtracking(&nums, path, used, &ans)
	return ans
}

func backtracking(nums *[]int, path []int, used []bool, ans *[][]int) {
	if len(path) == len(*nums) {
		tmp := make([]int, len(path))
		copy(tmp, path)
		*ans = append(*ans, tmp)
		return
	}
	for i := 0; i < len(*nums); i++ {
		n := (*nums)[i]
		if used[i] {
			continue
		}
		used[i] = true
		path = append(path, n)
		backtracking(nums, path, used, ans)
		path = path[:len(path)-1]
		used[i] = false
	}
}

//leetcode submit region end(Prohibit modification and deletion)
