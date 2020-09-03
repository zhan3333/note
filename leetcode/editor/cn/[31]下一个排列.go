package leetcode_golang

import "sort"

//实现获取下一个排列的函数，算法需要将给定数字序列重新排列成字典序中下一个更大的排列。
//
// 如果不存在下一个更大的排列，则将数字重新排列成最小的排列（即升序排列）。 
//
// 必须原地修改，只允许使用额外常数空间。 
//
// 以下是一些例子，输入位于左侧列，其相应输出位于右侧列。 
//1,2,3 → 1,3,2 
//3,2,1 → 1,2,3 
//1,1,5 → 1,5,1 
// Related Topics 数组

//leetcode submit region begin(Prohibit modification and deletion)
func nextPermutation(nums []int) {
	var isSorted = true
	for i := len(nums) - 2; i >= 0; i-- {
		if nums[i] < nums[i+1] {
			isSorted = false
			for j := len(nums) - 1; j > i; j-- {
				if nums[j] > nums[i] {
					nums[j], nums[i] = nums[i], nums[j]
					sort.Ints(nums[i+1:])
					break
				}
			}
			break
		}
	}
	if isSorted {
		sort.Ints(nums)
	}
}

//leetcode submit region end(Prohibit modification and deletion)
