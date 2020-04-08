<?php

// 给定一个整数，写一个函数来判断它是否是 3 的幂次方。
//
//示例 1:
//
//输入: 27
//输出: true
//示例 2:
//
//输入: 0
//输出: false
//示例 3:
//
//输入: 9
//输出: true
//示例 4:
//
//输入: 45
//输出: false
//进阶：
//你能不使用循环或者递归来完成本题吗？
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/power-of-three
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。


class Solution
{

    /**
     * 3^i = n => i = log3(n) => i = (logb(n) / logb(3))
     * 要注意 % 取模会直接去掉小数点后, 得到的是一个整数
     * 需要小数取余用 fmod(), 返回值是一个浮点数, 与0判断时要写成 === 0.0
     * @param Integer $n
     * @return Boolean
     */
    function isPowerOfThree($n)
    {
        if ($n < 1) {
            return false;
        }
        return fmod(log10($n) / log10(3), 1) === 0.0;
    }
}

$s = new Solution();

var_dump($s->isPowerOfThree(45)); // false
var_dump($s->isPowerOfThree(1)); // true
var_dump($s->isPowerOfThree(3)); // true
var_dump($s->isPowerOfThree(9)); // true