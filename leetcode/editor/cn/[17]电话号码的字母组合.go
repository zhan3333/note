package leetcode_golang

//给定一个仅包含数字 2-9 的字符串，返回所有它能表示的字母组合。
//
// 给出数字到字母的映射如下（与电话按键相同）。注意 1 不对应任何字母。 
//
// 
//
// 示例: 
//
// 输入："23"
//输出：["ad", "ae", "af", "bd", "be", "bf", "cd", "ce", "cf"].
// 
//
// 说明: 
//尽管上面的答案是按字典序排列的，但是你可以任意选择答案输出的顺序。 
// Related Topics 字符串 回溯算法

//leetcode submit region begin(Prohibit modification and deletion)
var m = map[uint8][]uint8{
	'2': {'a', 'b', 'c'},
	'3': {'d', 'e', 'f'},
	'4': {'g', 'h', 'i'},
	'5': {'j', 'k', 'l'},
	'6': {'m', 'n', 'o'},
	'7': {'p', 'q', 'r', 's'},
	'8': {'t', 'u', 'v'},
	'9': {'w', 'x', 'y', 'z'},
}

func letterCombinations(digits string) []string {
	var ans []string
	if len(digits) == 0 {
		return ans
	}
	backtracking(digits, 0, "", &ans)
	return ans
}

func backtracking(s string, i int, cur string, ans *[]string) {
	if i == len(s) {
		*ans = append(*ans, cur)
		return
	}
	c := s[i]
	for _, item := range m[c] {
		cur += string(item)
		backtracking(s, i+1, cur, ans)
		cur = cur[0 : len(cur)-1]
	}
}

//leetcode submit region end(Prohibit modification and deletion)
