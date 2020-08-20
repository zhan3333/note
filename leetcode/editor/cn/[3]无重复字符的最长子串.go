package leetcode_golang

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
	m := map[byte]int{}
	i := 0
	ans := 0
	for j, v := range []byte(s) {
		if _, ok := m[v]; ok {
			// 不去移除 < m[v] 的元素, 而是判断元素的index是否在范围内
			if m[v] > i {
				i = m[v]
			}
		}
		if ans < j-i+1 {
			ans = j - i + 1
		}
		// 更新元素的下标
		m[v] = j + 1
	}
	return ans
}

//leetcode submit region end(Prohibit modification and deletion)
