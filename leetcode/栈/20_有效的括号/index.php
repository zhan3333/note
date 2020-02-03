<?php

//给定一个只包括 '('，')'，'{'，'}'，'['，']' 的字符串，判断字符串是否有效。
//
//有效字符串需满足：
//
//左括号必须用相同类型的右括号闭合。
//左括号必须以正确的顺序闭合。
//注意空字符串可被认为是有效字符串。
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/valid-parentheses
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

// 思路
// 使用栈来解决这个问题, 左括号入栈, 右括号出栈进行匹配
// 注意奇数个的括号, 最后肯定会剩下一个多余的括号, 需要判断
// 当最后一个符号为多余的反括号时, $stack->pop()会报错
// 注意
// 注意特殊情况, 只有一个左括号或者只有一个右括号时

class Solution {
    function isValid(string $s): bool {
        $stack = new SplStack();
        $arr = [
            '(' => ')',
            '[' => ']',
            '{' => '}',
        ];
        foreach (str_split($s) as $c) {
            switch ($c) {
                case '':
                    break;
                case '(':
                case '[':
                case '{':
                    $stack->push($c);
                    break;
                case ')':
                case ']':
                case '}':
                    if ($stack->count() === 0 || ($arr[$stack->pop()] !== $c)) {
                        return false;
                    }
                    break;
                default:
                    return false;
            }
        }
        if (count($stack) > 0) {
            return false;
        }
        return true;
    }
}

$solution = new Solution();
var_dump($solution->isValid('()')); // true
var_dump($solution->isValid('()[]{}')); // true
var_dump($solution->isValid('(]')); // false
var_dump($solution->isValid('([))]')); // false
var_dump($solution->isValid('{[]}')); // true
var_dump($solution->isValid('')); // true
var_dump($solution->isValid('[')); // false
var_dump($solution->isValid(']')); // false