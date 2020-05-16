package search

import (
	"math"
)

//给定一个整数数组 nums ，找到一个具有最大和的连续子数组（子数组最少包含一个元素），返回其最大和。
//
//示例:
//
//输入: [-2,1,-3,4,-1,2,1,-5,4],
//输出: 6
//解释: 连续子数组 [4,-1,2,1] 的和最大，为 6。
//进阶:
//
//如果你已经实现复杂度为 O(n) 的解法，尝试使用更为精妙的分治法求解。

func maxSubArray(nums []int) int {
	// dp[i] = max(nums[i], nums[i-1] + nums[i])
	if len(nums) < 1 {
		return 0
	}
	max := nums[0]
	for i := 1; i < len(nums); i++ {
		nums[i] = int(math.Max(float64(nums[i]), float64(nums[i]+nums[i-1])))
		max = int(math.Max(float64(max), float64(nums[i])))
	}
	return max
}
