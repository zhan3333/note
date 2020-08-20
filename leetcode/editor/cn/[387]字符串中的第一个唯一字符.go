package leetcode_golang

//给定一个字符串，找到它的第一个不重复的字符，并返回它的索引。如果不存在，则返回 -1。 
//
// 
//
// 示例： 
//
// s = "leetcode"
//返回 0
//
//s = "loveleetcode"
//返回 2
// 
//
// 
//
// 提示：你可以假定该字符串只包含小写字母。 
// Related Topics 哈希表 字符串

//leetcode submit region begin(Prohibit modification and deletion)
func firstUniqChar(s string) int {
	m := map[uint8]int{}
	for i := 0; i < len(s); i++ {
		if _, ok := m[s[i]]; !ok {
			m[s[i]] = 0
		}
		m[s[i]]++
	}
	for i := 0; i < len(s); i++ {
		if m[s[i]] == 1 {
			return i
		}
	}
	return -1
}

//leetcode submit region end(Prohibit modification and deletion)
