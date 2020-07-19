package leetcode_golang

import (
	"fmt"
	"strings"
)

//给定一个字符串，验证它是否是回文串，只考虑字母和数字字符，可以忽略字母的大小写。 
//
// 说明：本题中，我们将空字符串定义为有效的回文串。 
//
// 示例 1: 
//
// 输入: "A man, a plan, a canal: Panama"
//输出: true
// 
//
// 示例 2: 
//
// 输入: "race a car"
//输出: false
// 
// Related Topics 双指针 字符串 
// 👍 250 👎 0

//leetcode submit region begin(Prohibit modification and deletion)
func isPalindrome(s string) bool {
	l := 0
	r := len(s) - 1
	for l < r {
		for l < r && !isAllowChar(s[l]) {
			l++
		}
		for l < r && !isAllowChar(s[r]) {
			r--
		}
		if strings.ToUpper(string(s[l])) != strings.ToUpper(string(s[r])) {
			fmt.Printf("a: %s, b: %s \n", s[l], s[r])
			return false
		}
		l++
		r--
	}
	return true
}

func isAllowChar(c uint8) bool {
	if (c >= 48 && c <= 57) || (c >= 65 && c <= 90) || (c >= 97 && c <= 122) {
		return true
	}
	return false
}

//leetcode submit region end(Prohibit modification and deletion)
