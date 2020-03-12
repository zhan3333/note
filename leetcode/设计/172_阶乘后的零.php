<?php

//给定一个整数 n，返回 n! 结果尾数中零的数量。
//
//示例 1:
//
//输入: 3
//输出: 0
//解释: 3! = 6, 尾数中没有零。
//示例 2:
//
//输入: 5
//输出: 1
//解释: 5! = 120, 尾数中有 1 个零.
//说明: 你算法的时间复杂度应为 O(log n) 。
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/factorial-trailing-zeroes
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

class Solution
{

    /**
     * 统计因子中有多少个5即可得出有多少个0
     * @param Integer $n
     * @return Integer
     */
    function trailingZeroes($n)
    {
        $count = 0;
        while ($n > 0) {
            $count += (int)($n / 5);
            $n = (int)($n / 5);
        }
        return $count;
    }
}

$s = new Solution();

var_dump($s->trailingZeroes(3)); // 0
var_dump($s->trailingZeroes(5)); // 1
var_dump($s->trailingZeroes(30)); // 7