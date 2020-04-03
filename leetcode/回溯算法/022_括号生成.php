<?php

// 给出 n 代表生成括号的对数，请你写出一个函数，使其能够生成所有可能的并且有效的括号组合。
//
//例如，给出 n = 3，生成结果为：
//
//[
//  "((()))",
//  "(()())",
//  "(())()",
//  "()(())",
//  "()()()"
//]
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/generate-parentheses
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

class Solution
{

    /**
     * n对括号, 用回溯法, open括号数量要小于n, close括号要小于 open
     * @param Integer $n
     * @return String[]
     */
    function generateParenthesis($n)
    {
        $ans = [];
        $this->backtrack($ans, '', 0, 0, $n);
        return $ans;
    }

    function backtrack(&$ans, $cur, $open, $close, $max)
    {
        if (strlen($cur) === $max * 2) {
            $ans[] = $cur;
            return;
        }
        if ($open < $max) {
            $this->backtrack($ans, $cur . '(', $open + 1, $close, $max);
        }
        if ($close < $open) {
            $this->backtrack($ans, $cur . ')', $open, $close + 1, $max);
        }
    }
}

$s = new Solution();
var_dump($s->generateParenthesis(3));