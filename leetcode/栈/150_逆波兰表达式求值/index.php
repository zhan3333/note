<?php

// 根据逆波兰表示法，求表达式的值。
//
//有效的运算符包括 +, -, *, / 。每个运算对象可以是整数，也可以是另一个逆波兰表达式。
//
//说明：
//
//整数除法只保留整数部分。
//给定逆波兰表达式总是有效的。换句话说，表达式总会得出有效数值且不存在除数为 0 的情况。
//示例 1：
//
//输入: ["2", "1", "+", "3", "*"]
//输出: 9
//解释: ((2 + 1) * 3) = 9
//示例 2：
//
//输入: ["4", "13", "5", "/", "+"]
//输出: 6
//解释: (4 + (13 / 5)) = 6
//示例 3：
//
//输入: ["10", "6", "9", "3", "+", "-11", "*", "/", "*", "17", "+", "5", "+"]
//输出: 22
//解释:
//  ((10 * (6 / ((9 + 3) * -11))) + 17) + 5
//= ((10 * (6 / (12 * -11))) + 17) + 5
//= ((10 * (6 / -132)) + 17) + 5
//= ((10 * 0) + 17) + 5
//= (0 + 17) + 5
//= 17 + 5
//= 22
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/evaluate-reverse-polish-notation
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

// 思考
// 逆波兰表示法指的是将运算符号放到后边的表示方法
// 显然包含了退步操作, 所以使用栈来储存
// 遇到表达式时, 弹出前两个数, 计算后push到栈中

class Solution
{

    /**
     * @param String[] $tokens
     * @return Integer
     */
    function evalRPN($tokens)
    {
        $stack = [];
        foreach ($tokens as $token) {
            if ($token === '+') {
                $p1 = array_pop($stack);
                $p2 = array_pop($stack);
                $stack[] = $p2 + $p1;
            } else if ($token === '-') {
                $p1 = array_pop($stack);
                $p2 = array_pop($stack);
                $stack[] = $p2 - $p1;
            } else if ($token === '*') {
                $p1 = array_pop($stack);
                $p2 = array_pop($stack);
                $stack[] = $p2 * $p1;
            } else if ($token === '/') {
                $p1 = array_pop($stack);
                $p2 = array_pop($stack);
                $stack[] = (int)($p2 / $p1);
            } else {
                $stack[] = (int)$token;
            }
        }
        return $stack[0];
    }
}

$s = new Solution();
var_dump($s->evalRPN(["2", "1", "+", "3", "*"])); // 9
var_dump($s->evalRPN(["4", "13", "5", "/", "+"])); // 6
var_dump($s->evalRPN(["10", "6", "9", "3", "+", "-11", "*", "/", "*", "17", "+", "5", "+"])); // 22