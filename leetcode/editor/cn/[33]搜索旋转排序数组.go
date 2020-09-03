package leetcode_golang

//假设按照升序排序的数组在预先未知的某个点上进行了旋转。
//
// ( 例如，数组 [0,1,2,4,5,6,7] 可能变为 [4,5,6,7,0,1,2] )。 
//
// 搜索一个给定的目标值，如果数组中存在这个目标值，则返回它的索引，否则返回 -1 。 
//
// 你可以假设数组中不存在重复的元素。 
//
// 你的算法时间复杂度必须是 O(log n) 级别。 
//
// 示例 1: 
//
// 输入: nums = [4,5,6,7,0,1,2], target = 0
//输出: 4
// 
//
// 示例 2: 
//
// 输入: nums = [4,5,6,7,0,1,2], target = 3
//输出: -1 
// Related Topics 数组 二分查找

//leetcode submit region begin(Prohibit modification and deletion)
func search(nums []int, target int) int {
	l, r := 0, len(nums)-1
	for l <= r {
		m := (l + r) / 2
		if nums[m] == target {
			return m
		} else if nums[m] < nums[r] {
			// 右侧有序
			if nums[m] < target && nums[r] >= target {
				// 在右侧
				l = m + 1
			} else {
				r = m - 1
			}
		} else {
			// 左侧有序
			if nums[m] > target && nums[l] <= target {
				// 在左侧
				r = m - 1
			} else {
				l = m + 1
			}
		}
	}
	return -1
}

//leetcode submit region end(Prohibit modification and deletion)
