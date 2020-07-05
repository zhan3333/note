package leetcode_golang

import "math"

//给定一个字符串，请你找出其中不含有重复字符的 最长子串 的长度。 
//
// 示例 1: 
//
// 输入: "abcabcbb"
//输出: 3 
//解释: 因为无重复字符的最长子串是 "abc"，所以其长度为 3。
// 
//
// 示例 2: 
//
// 输入: "bbbbb"
//输出: 1
//解释: 因为无重复字符的最长子串是 "b"，所以其长度为 1。
// 
//
// 示例 3: 
//
// 输入: "pwwkew"
//输出: 3
//解释: 因为无重复字符的最长子串是 "wke"，所以其长度为 3。
//     请注意，你的答案必须是 子串 的长度，"pwke" 是一个子序列，不是子串。
// 
// Related Topics 哈希表 双指针 字符串 Sliding Window

//leetcode submit region begin(Prohibit modification and deletion)
func lengthOfLongestSubstring(s string) int {
	// l 为无重复字符串开始下标
	// r 为当前所在下标
	// map 储存已经使用的字符, 值为所在的下标
	// 遍历字符串, 当遇到 map 中存在的字符时, l 设置为map中这个字符下标 + 1, 同时放弃掉 map 中下标小于 l 的字符
	// 直到遍历完毕
	var max = 0
	var l = 0
	var m = map[uint8]int{}
	for r := 0; r < len(s); r++ {
		if _, ok := m[s[r]]; ok {
			l = m[s[r]] + 1
			for k, v := range m {
				if v < l {
					delete(m, k)
				}
			}
		}
		m[s[r]] = r
		max = int(math.Max(float64(r-l+1), float64(max)))
	}
	return max
}

//leetcode submit region end(Prohibit modification and deletion)
