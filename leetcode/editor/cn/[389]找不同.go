package leetcode_golang

//给定两个字符串 s 和 t，它们只包含小写字母。
//
// 字符串 t 由字符串 s 随机重排，然后在随机位置添加一个字母。 
//
// 请找出在 t 中被添加的字母。 
//
// 
//
// 示例: 
//
// 输入：
//s = "abcd"
//t = "abcde"
//
//输出：
//e
//
//解释：
//'e' 是那个被添加的字母。
// 
// Related Topics 位运算 哈希表

//leetcode submit region begin(Prohibit modification and deletion)
func findTheDifference(s string, t string) byte {
	m := map[uint8]int{}
	for i := 0; i < len(t); i++ {
		m[t[i]]++
	}
	for i := 0; i < len(s); i++ {
		m[s[i]]--
		if m[s[i]] == 0 {
			delete(m, s[i])
		}
	}
	for v := range m {
		return v
	}
	panic("failed")
}

//leetcode submit region end(Prohibit modification and deletion)
