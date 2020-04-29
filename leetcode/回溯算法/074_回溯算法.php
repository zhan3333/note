<?php

/*
 * @lc app=leetcode.cn id=77 lang=php
 *
 * [77] 组合
 */

//给定两个整数 n 和 k，返回 1 ... n 中所有可能的 k 个数的组合。
//
//示例:
//
//输入: n = 4, k = 2
//输出:
//[
//  [2,4],
//  [3,4],
//  [2,3],
//  [1,2],
//  [1,3],
//  [1,4],
//]

// @lc code=start
class Solution
{

    private $ans = [];

    /**
     * 时间复杂度: O(n^k)
     * @param Integer $n
     * @param Integer $k
     * @return Integer[][]
     */
    function combine($n, $k)
    {
        $this->backtrack($n, $k, [], 1);
        return $this->ans;
    }

    function backtrack($n, $k, $trace, $start)
    {
        if (count($trace) === $k) {
            $this->ans[] = $trace;
            return;
        }
        for ($i = $start; $i <= $n; $i++) {
            $trace[] = $i;
            $this->backtrack($n, $k, $trace, $i + 1);
            array_pop($trace);
        }
    }
}
// @lc code=end

