package leetcode_golang

//统计所有小于非负整数 n 的质数的数量。 
//
// 示例: 
//
// 输入: 10
//输出: 4
//解释: 小于 10 的质数一共有 4 个, 它们是 2, 3, 5, 7 。
// 
// Related Topics 哈希表 数学

//leetcode submit region begin(Prohibit modification and deletion)
func countPrimes(n int) int {
	c := 0
	for i := 2; i < n; i++ {
		if isPrimes(i) {
			c++
		}
	}
	return c
}

func isPrimes(n int) bool {
	for i := 2; i < n; i++ {
		if n%i == 0 {
			return false
		}
	}
	return true
}

//leetcode submit region end(Prohibit modification and deletion)
