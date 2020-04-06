<?php

// 给定一个非负整数 num，反复将各个位上的数字相加，直到结果为一位数。
//
//示例:
//
//输入: 38
//输出: 2
//解释: 各位相加的过程为：3 + 8 = 11, 1 + 1 = 2。 由于 2 是一位数，所以返回 2。
//进阶:
//你可以不使用循环或者递归，且在 O(1) 时间复杂度内解决这个问题吗？
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/add-digits
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

class Solution
{

    function addDigits($num)
    {
        // 考虑到 9 的倍数直接模9的话得到的是0, 与我们想要的 9 不一样
        return ($num - 1) % 9 + 1;
    }

    /**
     * 暴力求解
     * @param Integer $num
     * @return Integer
     */
    function addDigits1($num)
    {
        if ($num < 10) {
            return $num;
        }
        while ($num > 9) {
            $sum = 0;
            while ($num > 0) {
                $sum += $num % 10;
                $num = (int)($num / 10);
            }
            $num = $sum;
        }
        return $num;
    }
}

$s = new Solution();

var_dump($s->addDigits(38)); // 2
var_dump($s->addDigits(10)); // 1