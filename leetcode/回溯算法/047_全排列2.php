<?php

// 给定一个可包含重复数字的序列，返回所有不重复的全排列。
//
//示例:
//
//输入: [1,1,2]
//输出:
//[
//  [1,1,2],
//  [1,2,1],
//  [2,1,1]
//]

class Solution
{

    private $ans = [];
    private $len;

    /**
     * 回溯法求解
     * @param Integer[] $nums
     * @return Integer[][]
     */
    function permuteUnique($nums)
    {
        $this->len = count($nums);
        $this->backtrack($nums, [], []);
        return $this->ans;
    }

    function backtrack(&$nums, $trace, $useIndexs)
    {
        if (count($trace) === $this->len) {
            $this->ans[] = $trace;
            return;
        }
        $use = [];
        for ($i = 0; $i < $this->len; $i++) {
            // 剪枝: 已经用过的数字不重复用
            if (!in_array($nums[$i], $use, true)) {
                // 剪枝: 已经用过的下标不再用
                if (!in_array($i, $useIndexs, true)) {
                    $trace[] = $nums[$i];
                    $useIndexs[] = $i;
                    $use[] = $nums[$i];
                    $this->backtrack($nums, $trace, $useIndexs);
                    array_pop($trace);
                    array_pop($useIndexs);
                }
            }
        }
    }
}