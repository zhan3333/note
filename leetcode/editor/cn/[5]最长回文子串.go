package leetcode_golang

//给定一个字符串 s，找到 s 中最长的回文子串。你可以假设 s 的最大长度为 1000。 
//
// 示例 1： 
//
// 输入: "babad"
//输出: "bab"
//注意: "aba" 也是一个有效答案。
// 
//
// 示例 2： 
//
// 输入: "cbbd"
//输出: "bb"
// 
// Related Topics 字符串 动态规划

//leetcode submit region begin(Prohibit modification and deletion)
func longestPalindrome(s string) string {
	if len(s) == 0 {
		return s
	}
	dp := [1000][1000]bool{}
	l := 0
	r := 0
	for i := 0; i < len(s); i++ {
		dp[i][i] = true
		for j := i - 1; j >= 0; j-- {
			// i-j == 1 是为了判断连个相邻字符是否为回文
			// dp[i-1][j+1] 是为了判断两端去除一个字符后是否为回文
			dp[i][j] = (s[i] == s[j]) && (i-j == 1 || dp[i-1][j+1])
			if dp[i][j] && r-l < i-j {
				l, r = j, i
			}
		}
	}
	return s[l : r+1]
}

//leetcode submit region end(Prohibit modification and deletion)
