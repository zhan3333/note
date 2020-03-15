<?php

// 给定一个整数，编写一个函数来判断它是否是 2 的幂次方。
//
//示例 1:
//
//输入: 1
//输出: true
//解释: 20 = 1
//示例 2:
//
//输入: 16
//输出: true
//解释: 24 = 16
//示例 3:
//
//输入: 218
//输出: false
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/power-of-two
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

class Solution
{

    function isPowerOfTwo($n)
    {
        if ($n <= 0) {
            return false;
        }
        return ($n & (-$n)) === $n;
    }

    /**
     * 时间复杂度: O(logN)
     * @param Integer $n
     * @return Boolean
     */
    function isPowerOfTwo1($n)
    {
        while ($n > 0) {
            if ($n === 1) {
                return true;
            }
            if ($n >> 1 !== $n / 2) {
                return false;
            }
            $n >>= 1;
        }
        return false;
    }
}

$s = new Solution();
var_dump($s->isPowerOfTwo(1)); // true
var_dump($s->isPowerOfTwo(8)); // true
var_dump($s->isPowerOfTwo(9)); // false
var_dump($s->isPowerOfTwo(16)); // true
var_dump($s->isPowerOfTwo(218)); // false