package leetcode_golang

//给定一个按照升序排列的整数数组 nums，和一个目标值 target。找出给定目标值在数组中的开始位置和结束位置。 
//
// 你的算法时间复杂度必须是 O(log n) 级别。 
//
// 如果数组中不存在目标值，返回 [-1, -1]。 
//
// 示例 1: 
//
// 输入: nums = [5,7,7,8,8,10], target = 8
//输出: [3,4] 
//
// 示例 2: 
//
// 输入: nums = [5,7,7,8,8,10], target = 6
//输出: [-1,-1] 
// Related Topics 数组 二分查找

//leetcode submit region begin(Prohibit modification and deletion)
func searchRange(nums []int, target int) []int {
	// 找这样的数 i-1 < target 或者 i-1 = -1, nums[i] = target
	// i = target 且 nums[i+1] = target 或 i+1 = len(nums)
	// 未找到时
	l, r := 0, len(nums)-1
	start, end := -1, -1
	// 找左边界
	for l <= r {
		m := (r + l) / 2
		if nums[m] == target {
			if m-1 == -1 || nums[m-1] < target {
				start = m
				break
			} else {
				r = m - 1
			}
		} else if nums[m] > target {
			r = m - 1
		} else {
			l = m + 1
		}
	}
	// 找右边界
	if start != -1 {
		l, r = start, len(nums)-1
		for l <= r {
			m := (r + l) / 2
			if nums[m] == target {
				if m+1 == len(nums) || nums[m+1] > target {
					end = m
					break
				} else {
					l = m + 1
				}
			} else if nums[m] > target {
				r = m - 1
			} else {
				l = m + 1
			}
		}
	}
	return []int{start, end}
}

//leetcode submit region end(Prohibit modification and deletion)
