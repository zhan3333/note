package leetcode_golang

//编写一个函数，以字符串作为输入，反转该字符串中的元音字母。
//
// 示例 1: 
//
// 输入: "hello"
//输出: "holle"
// 
//
// 示例 2: 
//
// 输入: "leetcode"
//输出: "leotcede" 
//
// 说明: 
//元音字母不包含字母"y"。 
// Related Topics 双指针 字符串

//leetcode submit region begin(Prohibit modification and deletion)
func reverseVowels(s string) string {
	b := []byte(s)
	var m []int
	for i := 0; i < len(b); i++ {
		if b[i] == 'a' || b[i] == 'e' || b[i] == 'i' || b[i] == 'o' || b[i] == 'u' || b[i] == 'A' || b[i] == 'E' || b[i] == 'I' || b[i] == 'O' || b[i] == 'U' {
			m = append(m, i)
		}
	}
	for i := 0; i < len(m)>>1; i++ {
		b[m[i]], b[m[len(m)-i-1]] = b[m[len(m)-i-1]], b[m[i]]
	}
	return string(b)
}

//leetcode submit region end(Prohibit modification and deletion)
