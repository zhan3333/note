<?php

// 给定一个整数 (32 位有符号整数)，请编写一个函数来判断它是否是 4 的幂次方。
//
//示例 1:
//
//输入: 16
//输出: true
//示例 2:
//
//输入: 5
//输出: false
//进阶：
//你能不使用循环或者递归来完成本题吗？
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/power-of-four
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

class Solution
{
    /**
     * @param Integer $num
     * @return Boolean
     */
    function isPowerOfFour($num)
    {
        if ($num < 1) {
            return false;
        }
        return fmod(log10($num) / log10(4), 1) === 0.0;
    }
}

$s = new Solution();

var_dump($s->isPowerOfFour(1)); // true
var_dump($s->isPowerOfFour(4)); // true
var_dump($s->isPowerOfFour(12)); // false
var_dump($s->isPowerOfFour(64)); // true