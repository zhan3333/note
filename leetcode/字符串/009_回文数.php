<?php

// 判断一个整数是否是回文数。回文数是指正序（从左向右）和倒序（从右向左）读都是一样的整数。
//
//示例 1:
//
//输入: 121
//输出: true
//示例 2:
//
//输入: -121
//输出: false
//解释: 从左向右读, 为 -121 。 从右向左读, 为 121- 。因此它不是一个回文数。
//示例 3:
//
//输入: 10
//输出: false
//解释: 从右向左读, 为 01 。因此它不是一个回文数。
//进阶:
//
//你能不将整数转为字符串来解决这个问题吗？
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/palindrome-number
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

// 思路
// 有以下方式可以解决问题
// 1. 转换为字符串, 从中心往两侧读, 在半径相同的情况下值不同, 就返回false
// 2. 不转换为字符串, 从末尾取数, 放到新数的开头, 直到原数为0 , 中间过程遇到两数相等, 即为正确结果
// 注意: 处理特殊情况在这里很重要
// 负数直接返回false
// 一位数直接返回true
// 当做了第一次转换后, $y === 0, 意味着不可能为回文数, 因为数字不能以0开头

class Solution
{

    /**
     * 字符串解法
     * @param Integer $x
     * @return Boolean
     */
    function isPalindrome1($x)
    {
        $s = '#' . implode('#', str_split((string)$x)) . '#';
        $len = strlen($s);
        $center = ($len - 1) / 2;
        for ($i = $center; $i >= 0; $i--) {
            if ($s[$i] !== $s[2 * $center - $i]) {
                return false;
            }
        }
        return true;
    }

    /**
     * 数字解法
     */
    function isPalindrome($x)
    {
        if ($x < 0) return false;
        if ($x < 10) return true;
        $y = 0;
        while ($x > $y) {
            $y = $y * 10 + $x % 10;
            $x = (int)($x / 10);
            if ($y === 0) {
                return false;
            }
        }
        return $x === $y || $x === (int)($y / 10);
    }
}

$s = new Solution();
var_dump($s->isPalindrome(121)); // true
var_dump($s->isPalindrome(-121)); // false
var_dump($s->isPalindrome(10)); // false
var_dump($s->isPalindrome(101)); // false
var_dump($s->isPalindrome(21120)); // false