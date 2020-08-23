package leetcode_golang

//给定一个正整数 num，编写一个函数，如果 num 是一个完全平方数，则返回 True，否则返回 False。 
//
// 说明：不要使用任何内置的库函数，如 sqrt。 
//
// 示例 1： 
//
// 输入：16
//输出：True 
//
// 示例 2： 
//
// 输入：14
//输出：False
// 
// Related Topics 数学 二分查找

//leetcode submit region begin(Prohibit modification and deletion)
func isPerfectSquare(num int) bool {
	if num == 1 {
		return true
	}
	if num < 1 {
		return false
	}
	m := num >> 1
	for i := m; i*i >= num; i-- {
		if i*i == num {
			return true
		}
	}
	return false
}

//leetcode submit region end(Prohibit modification and deletion)
