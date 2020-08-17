package leetcode_golang

import (
	"regexp"
	"strconv"
)

//给定一个整数，写一个函数来判断它是否是 3 的幂次方。 
//
// 示例 1: 
//
// 输入: 27
//输出: true
// 
//
// 示例 2: 
//
// 输入: 0
//输出: false 
//
// 示例 3: 
//
// 输入: 9
//输出: true 
//
// 示例 4: 
//
// 输入: 45
//输出: false 
//
// 进阶： 
//你能不使用循环或者递归来完成本题吗？ 
// Related Topics 数学

//leetcode submit region begin(Prohibit modification and deletion)
func isPowerOfThree2(n int) bool {
	match, _ := regexp.MatchString("^10*$", strconv.FormatInt(int64(n), 3))
	return match
}

func isPowerOfThree(n int) bool {
	return n > 0 && 1162261467%n == 0
}

//leetcode submit region end(Prohibit modification and deletion)
