package leetcode_golang

//给定一组不含重复元素的整数数组 nums，返回该数组所有可能的子集（幂集）。 
//
// 说明：解集不能包含重复的子集。 
//
// 示例: 
//
// 输入: nums = [1,2,3]
//输出:
//[
//  [3],
//  [1],
//  [2],
//  [1,2,3],
//  [1,3],
//  [2,3],
//  [1,2],
//  []
//] 
// Related Topics 位运算 数组 回溯算法 
// 👍 780 👎 0

//leetcode submit region begin(Prohibit modification and deletion)
func subsets(nums []int) [][]int {
	var ans [][]int
	backtracking(nums, 0, []int{}, &ans)
	return ans
}

func backtracking(nums []int, i int, path []int, ans *[][]int) {
	tmp := make([]int, len(path))
	copy(tmp, path)
	*ans = append(*ans, tmp)
	if i >= len(nums) {
		return
	}
	for j := i; j < len(nums); j++ {
		path = append(path, nums[j])
		backtracking(nums, j+1, path, ans)
		path = path[:len(path)-1]
	}
}

//leetcode submit region end(Prohibit modification and deletion)
