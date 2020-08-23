package leetcode_golang

//给定一个赎金信 (ransom) 字符串和一个杂志(magazine)字符串，判断第一个字符串 ransom 能不能由第二个字符串 magazines 里面
//的字符构成。如果可以构成，返回 true ；否则返回 false。 
//
// (题目说明：为了不暴露赎金信字迹，要从杂志上搜索各个需要的字母，组成单词来表达意思。杂志字符串中的每个字符只能在赎金信字符串中使用一次。) 
//
// 
//
// 注意： 
//
// 你可以假设两个字符串均只含有小写字母。 
//
// canConstruct("a", "b") -> false
//canConstruct("aa", "ab") -> false
//canConstruct("aa", "aab") -> true
// 
// Related Topics 字符串

//leetcode submit region begin(Prohibit modification and deletion)
func canConstruct(ransomNote string, magazine string) bool {
	m := map[uint8]int{}
	for i := 0; i < len(ransomNote); i++ {
		if _, ok := m[ransomNote[i]]; !ok {
			m[ransomNote[i]] = 0
		}
		m[ransomNote[i]]++
	}
	if len(m) == 0 {
		return true
	}
	for i := 0; i < len(magazine); i++ {
		if _, ok := m[magazine[i]]; ok {
			m[magazine[i]]--
			if m[magazine[i]] == 0 {
				delete(m, magazine[i])
			}
		}
		if len(m) == 0 {
			return true
		}
	}
	return false
}

//leetcode submit region end(Prohibit modification and deletion)
