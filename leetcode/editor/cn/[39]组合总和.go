package leetcode_golang

import (
	"sort"
)

//给定一个无重复元素的数组 candidates 和一个目标数 target ，找出 candidates 中所有可以使数字和为 target 的组合。 
//
// candidates 中的数字可以无限制重复被选取。 
//
// 说明： 
//
// 
// 所有数字（包括 target）都是正整数。 
// 解集不能包含重复的组合。 
// 
//
// 示例 1： 
//
// 输入：candidates = [2,3,6,7], target = 7,
//所求解集为：
//[
//  [7],
//  [2,2,3]
//]
// 
//
// 示例 2： 
//
// 输入：candidates = [2,3,5], target = 8,
//所求解集为：
//[
//  [2,2,2,2],
//  [2,3,3],
//  [3,5]
//] 
//
// 
//
// 提示： 
//
// 
// 1 <= candidates.length <= 30 
// 1 <= candidates[i] <= 200 
// candidate 中的每个元素都是独一无二的。 
// 1 <= target <= 500 
// 
// Related Topics 数组 回溯算法

//leetcode submit region begin(Prohibit modification and deletion)

func combinationSum(candidates []int, target int) [][]int {
	sort.Ints(candidates)
	var ans [][]int
	// 两条例线, 一条包含历史的计数, 另一个条不包含历史
	for i := range candidates {
		backtracking(&candidates, i, candidates[i], []int{candidates[i]}, target, &ans)
	}
	return ans
}

func backtracking(candidates *[]int, i int, sum int, history []int, target int, ans *[][]int) {
	if sum == target {
		*ans = append(*ans, append([]int{}, history...))
		return
	} else if sum > target {
		return
	}
	// 不带历史
	for ; i < len(*candidates); i++ {
		v := (*candidates)[i]
		backtracking(candidates, i, sum+v, append(history, v), target, ans)
	}
}

//leetcode submit region end(Prohibit modification and deletion)
