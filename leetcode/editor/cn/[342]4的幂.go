package leetcode_golang

import (
	"regexp"
	"strconv"
)

//给定一个整数 (32 位有符号整数)，请编写一个函数来判断它是否是 4 的幂次方。 
//
// 示例 1: 
//
// 输入: 16
//输出: true
// 
//
// 示例 2: 
//
// 输入: 5
//输出: false 
//
// 进阶： 
//你能不使用循环或者递归来完成本题吗？ 
// Related Topics 位运算

//leetcode submit region begin(Prohibit modification and deletion)
func isPowerOfFour(num int) bool {
	match, _ := regexp.MatchString("^10*$", strconv.FormatInt(int64(num), 4))
	return match
}

//leetcode submit region end(Prohibit modification and deletion)
