package leetcode_golang

//数字 n 代表生成括号的对数，请你设计一个函数，用于能够生成所有可能的并且 有效的 括号组合。 
//
// 
//
// 示例： 
//
// 输入：n = 3
//输出：[
//       "((()))",
//       "(()())",
//       "(())()",
//       "()(())",
//       "()()()"
//     ]
//

// ")(" error: 反括号前一定要有足够的正括号
// Related Topics 字符串 回溯算法

//leetcode submit region begin(Prohibit modification and deletion)
func generateParenthesis(n int) []string {
	var ans []string
	if n == 0 {
		return ans
	}
	backtracking(n, 0, 0, "", &ans)
	return ans
}

func backtracking(n int, l int, r int, s string, ans *[]string) {
	// 叶子
	if n == l && n == r {
		*ans = append(*ans, s)
		return
	}
	// 进入下一层
	if l < n {
		backtracking(n, l+1, r, s+"(", ans)
	}
	if r < n && r < l {
		backtracking(n, l, r+1, s+")", ans)
	}
	return
}

//leetcode submit region end(Prohibit modification and deletion)
