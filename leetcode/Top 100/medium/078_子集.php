<?php

// 给定一组不含重复元素的整数数组 nums，返回该数组所有可能的子集（幂集）。
//
//说明：解集不能包含重复的子集。
//
//示例:
//
//输入: nums = [1,2,3]
//输出:
//[
//  [3],
//  [1],
//  [2],
//  [1,2,3],
//  [1,3],
//  [2,3],
//  [1,2],
//  []
//]
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/subsets
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

class Solution
{

    private $ans = [];

    /**
     * 从后往前遍历, 每遇到一个数, 就加到原来的所有子集后边, 形成新的子集
     * @param $nums
     */
    function subsets($nums)
    {
        $ans = [[]];
        $len = count($nums);
        for ($i = $len - 1; $i >= 0; $i--) {
            $subLen = count($ans);
            $appendAns = [];
            for ($j = 0; $j < $subLen; $j++) {
                $appendAns[] = array_merge($ans[$j], [$nums[$i]]);
            }
            $ans = array_merge($ans, $appendAns);
        }
        return $ans;
    }

    /**
     * 回溯法求子集
     * @param Integer[] $nums
     * @return Integer[][]
     */
    function subsets1($nums)
    {
        $this->backtrack($nums, 0, []);
        return $this->ans;
    }

    function backtrack($nums, $start, $path)
    {
        $this->ans[] = $path;
        $len = count($nums);
        for ($i = $start; $i < $len; $i++) {
            $path[] = $nums[$i];
            $this->backtrack($nums, $i + 1, $path);
            array_pop($path);
        }
    }
}