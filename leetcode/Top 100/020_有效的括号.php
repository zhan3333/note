<?php

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

class Solution
{
    /**
     * 循环替换 () {} [] 成对的括号
     * @param string $s
     * @return bool
     */
    function isValid(string $s): bool
    {
        while (strpos($s, '()') !== false
            || strpos($s, '{}') !== false
            || strpos($s, '[]') !== false) {
            $s = str_replace(array('()', '{}', '[]'), '', $s);
        }
        return $s === '';
    }

    /**
     * 使用栈来实现
     * 空间复杂度: O(n) 最多字符串长度的空间使用
     * 时间复杂度: O(n) 遍历一次字符串
     * @param string $s
     * @return bool
     */
    function isValid1(string $s): bool
    {
        $map = [
            '(' => ')',
            '[' => ']',
            '{' => '}',
        ];
        $stack = [];
        $len = strlen($s);
        // 奇数位直接返回
        if ($len & 1 !== 0) {
            return false;
        }
        for ($i = 0; $i < $len; $i++) {
            // 超过了长度的一半, 肯定无效, 直接返回
            if (count($stack) > ($len >> 1)) {
                return false;
            }
            $char = $s[$i];
            if ($char === '(' || $char === '[' || $char === '{') {
                $stack[] = $char;
            } else {
                if ($char !== $map[$stack[count($stack) - 1]]) {
                    return false;
                }

                array_pop($stack);
            }
        }
        return empty($stack);
    }
}