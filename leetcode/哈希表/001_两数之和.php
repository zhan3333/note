<?php

//给定一个整数数组 nums 和一个目标值 target，请你在该数组中找出和为目标值的那 两个 整数，并返回他们的数组下标。
//
//你可以假设每种输入只会对应一个答案。但是，你不能重复利用这个数组中同样的元素。
//
//示例:
//
//给定 nums = [2, 7, 11, 15], target = 9
//
//因为 nums[0] + nums[1] = 2 + 7 = 9
//所以返回 [0, 1]
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/two-sum
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

// 思路
// 1. 暴力法, 两次遍历
// 2. 哈希表法, 哈希表储存值与index的关系, 可以通过一次遍历找到 v1 = target - v2 在不在哈希表中, 快速找到答案

class Solution
{

    /**
     * 暴力循环查找法
     * O(1) 空间复杂度
     * O(n^2) 时间复杂度
     * @param Integer[] $nums
     * @param Integer $target
     * @return Integer[]
     */
    function twoSum1($nums, $target)
    {
        $count = count($nums);
        for ($i = 0; $i < $count - 1; $i++) {
            for ($j = $i + 1; $j < $count; $j++) {
                if ($nums[$i] + $nums[$j]) {
                    return [$i, $j];
                }
            }
        }
        return [];
    }

    /**
     * O(n) 空间复杂度
     * O(n) 时间复杂度的查询方法, 可以用这种方法的核心在于, $target - $1 = $2, 这种查找不需要区分 1和2
     * 循环一次数组, 在map中储存 [$value] = $index 这样的结构, 可以快速的通过$value查找到$index, 而 $value = $target - $currentValue
     * @param $nums
     * @param $target
     * @return array
     */
    function twoSum2($nums, $target)
    {
        $map = [];
        for ($i = 0, $count = count($nums); $i < $count; $i++) {
            if (isset($map[$target - $nums[$i]])) {
                return [$map[$target - $nums[$i]], $i];
            }
            if (!isset($map[$nums[$i]])) {
                $map[$nums[$i]] = $i;
            }
        }
    }
}

$s = new Solution();
var_dump($s->twoSum1([2, 7, 11, 15], 9)); // [0, 1]
var_dump($s->twoSum2([2, 7, 11, 15], 9)); // [0, 1]