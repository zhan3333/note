package leetcode_golang

//给定两个字符串 s 和 t ，编写一个函数来判断 t 是否是 s 的字母异位词。 
//
// 示例 1: 
//
// 输入: s = "anagram", t = "nagaram"
//输出: true
// 
//
// 示例 2: 
//
// 输入: s = "rat", t = "car"
//输出: false 
//
// 说明: 
//你可以假设字符串只包含小写字母。 
//
// 进阶: 
//如果输入字符串包含 unicode 字符怎么办？你能否调整你的解法来应对这种情况？ 
// Related Topics 排序 哈希表

//leetcode submit region begin(Prohibit modification and deletion)
func isAnagram(s string, t string) bool {
	m := map[int32]int{}
	for _, c := range s {
		if _, ok := m[c]; !ok {
			m[c] = 0
		}
		m[c]++
	}
	for _, c := range t {
		if _, ok := m[c]; !ok {
			return false
		}
		m[c]--
		if m[c] == 0 {
			delete(m, c)
		}
	}
	return len(m) == 0
}

//leetcode submit region end(Prohibit modification and deletion)
