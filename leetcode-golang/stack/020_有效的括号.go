package stack

// 给定一个只包括 '('，')'，'{'，'}'，'['，']' 的字符串，判断字符串是否有效。
//
//有效字符串需满足：
//
//左括号必须用相同类型的右括号闭合。
//左括号必须以正确的顺序闭合。
//注意空字符串可被认为是有效字符串。
//
//示例 1:
//
//输入: "()"
//输出: true
//示例 2:
//
//输入: "()[]{}"
//输出: true
//示例 3:
//
//输入: "(]"
//输出: false
//示例 4:
//
//输入: "([)]"
//输出: false
//示例 5:
//
//输入: "{[]}"
//输出: true
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/valid-parentheses
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

func isValid(s string) bool {
	stack := []string{}
	m := map[string]string{
		")": "(",
		"]": "[",
		"}": "{",
	}
	sLenDiv2 := len(s) >> 1
	for _, v := range s {
		c := string(v)
		if c == "(" || c == "[" || c == "{" {
			stack = append(stack, c)
		} else {
			if len(stack) == 0 {
				return false
			}
			if stack[len(stack)-1] != m[c] {
				return false
			}
			stack = stack[:len(stack)-1]
		}
		if len(stack) > sLenDiv2 {
			return false
		}
	}
	return len(stack) == 0
}
