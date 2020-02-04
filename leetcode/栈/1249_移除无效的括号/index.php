<?php

// 给你一个由 '('、')' 和小写字母组成的字符串 s。
//
//你需要从字符串中删除最少数目的 '(' 或者 ')' （可以删除任意位置的括号)，使得剩下的「括号字符串」有效。
//
//请返回任意一个合法字符串。
//
//有效「括号字符串」应当符合以下 任意一条 要求：
//
//空字符串或只包含小写字母的字符串
//可以被写作 AB（A 连接 B）的字符串，其中 A 和 B 都是有效「括号字符串」
//可以被写作 (A) 的字符串，其中 A 是一个有效的「括号字符串」
// 
//
//示例 1：
//
//输入：s = "lee(t(c)o)de)"
//输出："lee(t(c)o)de"
//解释："lee(t(co)de)" , "lee(t(c)ode)" 也是一个可行答案。
//示例 2：
//
//输入：s = "a)b(c)d"
//输出："ab(c)d"
//示例 3：
//
//输入：s = "))(("
//输出：""
//解释：空字符串也是有效的
//示例 4：
//
//输入：s = "(a(b(c)d)"
//输出："a(b(c)d)"
// 
//
//提示：
//
//1 <= s.length <= 10^5
//s[i] 可能是 '('、')' 或英文小写字母
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/minimum-remove-to-make-valid-parentheses
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

// 思路
// 使用栈来记录(的位置
// 当遇到无法消去的)标记起来
// 最后没有消去的(标记起来
// 最后将标记的位置都置为空

class Solution {

    /**
     * @param String $s
     * @return String
     */
    function minRemoveToMakeValid($s) {
        $stack = [];
        $sCount = strlen($s);
        for ($i = 0; $i < $sCount ; $i ++) {
            if ($s[$i] === '(') {
                $stack[] = $i;
            }
            if ($s[$i] === ')') {
                if (empty($stack)) {
                    $s[$i] = '.';
                } else {
                    array_pop($stack);
                }
            }
        }
        while (!empty($stack)) {
            $s[array_pop($stack)] = '.';
        }
        return str_replace('.', '', $s);
    }
}

$s = new Solution();
print_r($s->minRemoveToMakeValid('lee(t(c)o)de)')); // lee(t(c)o)de