package design

import "sort"

// 给你一个包含 n 个整数的数组 nums，判断 nums 中是否存在三个元素 a，b，c ，使得 a + b + c = 0 ？请你找出所有满足条件且不重复的三元组。
//
//注意：答案中不可以包含重复的三元组。
//
//
//
//示例：
//
//给定数组 nums = [-1, 0, 1, 2, -1, -4]，
//
//满足要求的三元组集合为：
//[
//  [-1, 0, 1],
//  [-1, -1, 2]
//]

func threeSum(nums []int) [][]int {
	var ans [][]int
	sort.Ints(nums)
	for i, _ := range nums {
		if i == 0 || nums[i] > nums[i-1] {
			l := i + 1
			r := len(nums) - 1
			for l < r {
				s := nums[i] + nums[l] + nums[r]
				if s == 0 {
					ans = append(ans, []int{nums[i], nums[l], nums[r]})
					l++
					r--
					for l < r && (nums[l] == nums[l-1]) {
						l++
					}
					for l < r && (nums[r] == nums[r+1]) {
						r--
					}
				} else if s > 0 {
					r--
				} else {
					l++
				}
			}
		}
	}
	return ans
}
