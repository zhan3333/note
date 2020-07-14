package leetcode_golang

import (
	"strconv"
)

//给你两个二进制字符串，返回它们的和（用二进制表示）。 
//
// 输入为 非空 字符串且只包含数字 1 和 0。 
//
// 
//
// 示例 1: 
//
// 输入: a = "11", b = "1"
//输出: "100" 
//
// 示例 2: 
//
// 输入: a = "1010", b = "1011"
//输出: "10101" 
//
// 
//
// 提示： 
//
// 
// 每个字符串仅由字符 '0' 或 '1' 组成。 
// 1 <= a.length, b.length <= 10^4 
// 字符串如果不是 "0" ，就都不含前导零。 
// 
// Related Topics 数学 字符串

//leetcode submit region begin(Prohibit modification and deletion)
func addBinary(a string, b string) string {
	i := len(a) - 1
	j := len(b) - 1
	up := 0
	c := ""
	for i >= 0 || j >= 0 || up != 0 {
		n := up
		if i >= 0 {
			n += int(a[i] - 48)
			i--
		}
		if j >= 0 {
			n += int(b[j] - 48)
			j--
		}
		c = strconv.Itoa(n%2) + c
		up = n / 2
	}
	return c
}

//leetcode submit region end(Prohibit modification and deletion)
