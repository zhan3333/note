<?php

// 给定一个没有重复数字的序列，返回其所有可能的全排列。
//
//示例:
//
//输入: [1,2,3]
//输出:
//[
//  [1,2,3],
//  [1,3,2],
//  [2,1,3],
//  [2,3,1],
//  [3,1,2],
//  [3,2,1]
//]
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/permutations
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

class Solution
{

    private $res = [];

    /**
     * 回溯算法, 无法很好的优化, 复杂度很高, 因为要列出所有可能的排列
     * 时间复杂度: O(n!)
     * 空间复杂度: O(n!)
     * @param $nums
     * @return array
     */
    function permute($nums)
    {
        $track = [];
        $this->backtrack($nums, $track);
        return $this->res;
    }

    function backtrack($nums, $track)
    {
        if (count($nums) === count($track)) {
            // 到达了底层
            $this->res[] = $track;
            return;
        }
        for ($i = 0, $iMax = count($nums); $i < $iMax; $i++) {
            if (!in_array($nums[$i], $track, true)) {
                $track[] = $nums[$i];
                $this->backtrack($nums, $track);
                array_pop($track);
            }
        }
    }
}

$s = new Solution();

//[
//  [1,2,3],
//  [1,3,2],
//  [2,1,3],
//  [2,3,1],
//  [3,1,2],
//  [3,2,1]
//]
var_dump($s->permute([1, 2, 3]));