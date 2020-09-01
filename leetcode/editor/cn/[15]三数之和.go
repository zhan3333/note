package leetcode_golang

import (
	"sort"
)

//给你一个包含 n 个整数的数组 nums，判断 nums 中是否存在三个元素 a，b，c ，使得 a + b + c = 0 ？请你找出所有满足条件且不重复
//的三元组。 
//
// 注意：答案中不可以包含重复的三元组。 
//
// 
//
// 示例： 
//
// 给定数组 nums = [-1, 0, 1, 2, -1, -4]，
//
//满足要求的三元组集合为：
//[
//  [-1, 0, 1],
//  [-1, -1, 2]
//]
// 
// Related Topics 数组 双指针

//leetcode submit region begin(Prohibit modification and deletion)
func threeSum(nums []int) [][]int {
	// 排序后进行遍历查值
	// 排序 O(nLogN) + 循环 O(n^2) = O(n ^ 2)
	// 关键要考虑到相同数字需要跳过
	var ans [][]int
	if len(nums) < 3 {
		return ans
	}
	sort.Ints(nums)
	i := 0
	for i < len(nums)-2 {
		j, k := i+1, len(nums)-1
		for j < k {
			sum := nums[j] + nums[k]
			if sum == -nums[i] {
				ans = append(ans, []int{nums[i], nums[j], nums[k]})
				for j < k && nums[k] == nums[k-1] {
					k--
				}
				for j < k && nums[j] == nums[j+1] {
					j++
				}
				k--
				j++
			} else if sum > -nums[i] {
				for j < k && nums[k] == nums[k-1] {
					k--
				}
				k--
			} else {
				for j < k && nums[j] == nums[j+1] {
					j++
				}
				j++
			}
		}
		for i < len(nums)-2 && nums[i] == nums[i+1] {
			i++
		}
		i++
	}
	return ans
}

//leetcode submit region end(Prohibit modification and deletion)
