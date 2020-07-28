package leetcode_golang

//给定两个字符串 s 和 t，判断它们是否是同构的。 
//
// 如果 s 中的字符可以被替换得到 t ，那么这两个字符串是同构的。 
//
// 所有出现的字符都必须用另一个字符替换，同时保留字符的顺序。两个字符不能映射到同一个字符上，但字符可以映射自己本身。 
//
// 示例 1: 
//
// 输入: s = "egg", t = "add"
//输出: true
// 
//
// 示例 2: 
//
// 输入: s = "foo", t = "bar"
//输出: false 
//
// 示例 3: 
//
// 输入: s = "paper", t = "title"
//输出: true 
//
// 说明: 
//你可以假设 s 和 t 具有相同的长度。 
// Related Topics 哈希表

//leetcode submit region begin(Prohibit modification and deletion)
func isIsomorphic(s string, t string) bool {
	// 记录上一次替换的位置, 每个字符找这个位置的结果,对比值是否相等
	h := map[int32]int{}
	g := map[int32]int{}
	sa := []int32(s)
	ta := []int32(t)
	for i := 0; i < len(s); i++ {
		m := sa[i]
		n := ta[i]
		if index, ok := h[m]; ok {
			// 上一次替换的位置的值与这一次将会替换的不一致, 返回 false
			if ta[index] != n {
				return false
			}
		}
		if index, ok := g[n]; ok {
			if sa[index] != m {
				return false
			}
		}
		h[m] = i
		g[n] = i
	}
	return true
}

//leetcode submit region end(Prohibit modification and deletion)
