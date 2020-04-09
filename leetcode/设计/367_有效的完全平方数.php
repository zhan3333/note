<?php

// 给定一个正整数 num，编写一个函数，如果 num 是一个完全平方数，则返回 True，否则返回 False。
//
//说明：不要使用任何内置的库函数，如  sqrt。
//
//示例 1：
//
//输入：16
//输出：True
//示例 2：
//
//输入：14
//输出：False
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/valid-perfect-square
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

class Solution
{

    function isPerfectSquare($num)
    {
        if ($num < 1) {
            return false;
        }
        $start = 1;
        $end = $num;
        while ($start <= $end) {
            $mid = (int)(($end - $start) / 2) + $start;
            $pow = $mid ** 2;
            if ($pow === $num) {
                return true;
            } elseif ($pow > $num) {
                $end = $mid - 1;
            } else {
                $start = $mid + 1;
            }
        }
        return false;
    }


    /**
     * @param Integer $num
     * @return Boolean
     */
    function isPerfectSquare1($num)
    {
        if ($num < 1) {
            return false;
        }
        return fmod($num ** 0.5, 1) === 0.0;
    }
}

$s = new Solution();
var_dump($s->isPerfectSquare(1)); // true
var_dump($s->isPerfectSquare(16)); // true
var_dump($s->isPerfectSquare(14)); // false