<?php

// 实现 pow(x, n) ，即计算 x 的 n 次幂函数。
//
//示例 1:
//
//输入: 2.00000, 10
//输出: 1024.00000
//示例 2:
//
//输入: 2.10000, 3
//输出: 9.26100
//示例 3:
//
//输入: 2.00000, -2
//输出: 0.25000
//解释: 2-2 = 1/22 = 1/4 = 0.25
//说明:
//
//-100.0 < x < 100.0
//n 是 32 位有符号整数，其数值范围是 [−231, 231 − 1] 。

class Solution
{

    /**
     * 用分治法降低时间复杂度
     * 暴力时间复杂度: O(n)
     * 分治时间复杂度: O(logN)
     * @param Float $x
     * @param Integer $n
     * @return Float
     */
    function myPow($x, $n)
    {
        if ($n === 0) {
            return 1;
        }
        if ($n < 0) {
            // 负数次幂
            return 1 / $this->power($x, -$n);
        } else {
            return $this->power($x, $n);
        }
    }

    // $n > 0
    function power($x, $n)
    {
        if ($n === 1) {
            return $x;
        }
        if (($n & 1) === 1) {
            return $this->power($x, ($n - 1) >> 1) ** 2 * $x;
        } else {
            return $this->power($x, $n >> 1) ** 2;
        }
    }
}