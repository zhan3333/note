package leetcode_golang

//给定一个排序数组和一个目标值，在数组中找到目标值，并返回其索引。如果目标值不存在于数组中，返回它将会被按顺序插入的位置。 
//
// 你可以假设数组中无重复元素。 
//
// 示例 1: 
//
// 输入: [1,3,5,6], 5
//输出: 2
// 
//
// 示例 2: 
//
// 输入: [1,3,5,6], 2
//输出: 1
// 
//
// 示例 3: 
//
// 输入: [1,3,5,6], 7
//输出: 4
// 
//
// 示例 4: 
//
// 输入: [1,3,5,6], 0
//输出: 0
// 
// Related Topics 数组 二分查找

//leetcode submit region begin(Prohibit modification and deletion)
func searchInsert(nums []int, target int) int {
	if len(nums) == 0 {
		return -1
	}
	l := 0
	r := len(nums) - 1
	for l < r {
		mid := (r + l) / 2
		if target == nums[mid] {
			return mid
		} else if target < nums[mid] {
			r = mid - 1
		} else {
			l = mid + 1
		}
	}
	nums = append(nums, 0)
	if nums[l] < target {
		l++
	}
	for i := len(nums) - 2; i >= l; i-- {
		nums[i+1] = nums[i]
	}
	nums[l] = target
	return l
}

//leetcode submit region end(Prohibit modification and deletion)
