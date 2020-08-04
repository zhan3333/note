package leetcode_golang

//给定一个数组 nums，编写一个函数将所有 0 移动到数组的末尾，同时保持非零元素的相对顺序。 
//
// 示例: 
//
// 输入: [0,1,0,3,12]
//输出: [1,3,12,0,0] 
//
// 说明: 
//
// 
// 必须在原数组上操作，不能拷贝额外的数组。 
// 尽量减少操作次数。 
// 
// Related Topics 数组 双指针

//leetcode submit region begin(Prohibit modification and deletion)
func moveZeroes(nums []int) {
	// 冒泡排序走一个
	for i := 0; i < len(nums); i++ {
		swap := false
		for j := 0; j < len(nums)-1; j++ {
			if nums[j] == 0 && nums[j+1] != 0 {
				swap = true
				t := nums[j]
				nums[j] = nums[j+1]
				nums[j+1] = t
			}
		}
		if !swap {
			break
		}
	}
}

//leetcode submit region end(Prohibit modification and deletion)
