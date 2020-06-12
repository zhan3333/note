package leetcode_golang

import "math"

//给定一个Excel表格中的列名称，返回其相应的列序号。
//
// 例如， 
//
//     A -> 1
//    B -> 2
//    C -> 3
//    ...
//    Z -> 26
//    AA -> 27
//    AB -> 28 
//    ...
// 
//
// 示例 1: 
//
// 输入: "A"
//输出: 1
// 
//
// 示例 2: 
//
// 输入: "AB"
//输出: 28
// 
//
// 示例 3: 
//
// 输入: "ZY"
//输出: 701 
//
// 致谢： 
//特别感谢 @ts 添加此问题并创建所有测试用例。 
// Related Topics 数学

//leetcode submit region begin(Prohibit modification and deletion)
func titleToNumber(s string) int {
	if s == "" {
		return 0
	}
	ans := 0
	for i := len(s) - 1; i >= 0; i-- {
		ans += (int(s[i]) - int('A') + 1) * int(math.Pow(float64(26), float64(len(s)-i-1)))
	}
	return ans
}

//leetcode submit region end(Prohibit modification and deletion)
