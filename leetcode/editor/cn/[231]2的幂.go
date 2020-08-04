package leetcode_golang

//给定一个整数，编写一个函数来判断它是否是 2 的幂次方。 
//
// 示例 1: 
//
// 输入: 1
//输出: true
//解释: 20 = 1 
//
// 示例 2: 
//
// 输入: 16
//输出: true
//解释: 24 = 16 
//
// 示例 3: 
//
// 输入: 218
//输出: false 
// Related Topics 位运算 数学

//leetcode submit region begin(Prohibit modification and deletion)
func isPowerOfTwo(n int) bool {
	// 2的幂减去1的所有位都为1
	// 2的幕只有一个1
	c := 0
	for n > 0 {
		if n&1 == 1 {
			c++
			if c > 1 {
				return false
			}
		}
		n >>= 1
	}
	return c == 1
}

//leetcode submit region end(Prohibit modification and deletion)
