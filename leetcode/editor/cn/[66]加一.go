package leetcode_golang

//给定一个由整数组成的非空数组所表示的非负整数，在该数的基础上加一。 
//
// 最高位数字存放在数组的首位， 数组中每个元素只存储单个数字。 
//
// 你可以假设除了整数 0 之外，这个整数不会以零开头。 
//
// 示例 1: 
//
// 输入: [1,2,3]
//输出: [1,2,4]
//解释: 输入数组表示数字 123。
// 
//
// 示例 2: 
//
// 输入: [4,3,2,1]
//输出: [4,3,2,2]
//解释: 输入数组表示数字 4321。
// 
// Related Topics 数组

//leetcode submit region begin(Prohibit modification and deletion)
func plusOne(digits []int) []int {
	up := 1
	for i := len(digits) - 1; i >= 0; i-- {
		n := digits[i] + up
		digits[i] = n % 10
		up = n / 10
	}
	if up != 0 {
		digits = append([]int{1}, digits...)
	}
	return digits
}

//leetcode submit region end(Prohibit modification and deletion)
