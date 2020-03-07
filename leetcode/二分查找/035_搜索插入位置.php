<?php

// 给定一个排序数组和一个目标值，在数组中找到目标值，并返回其索引。如果目标值不存在于数组中，返回它将会被按顺序插入的位置。
//
//你可以假设数组中无重复元素。
//
//示例 1:
//
//输入: [1,3,5,6], 5
//输出: 2
//示例 2:
//
//输入: [1,3,5,6], 2
//输出: 1
//示例 3:
//
//输入: [1,3,5,6], 7
//输出: 4
//示例 4:
//
//输入: [1,3,5,6], 0
//输出: 0
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/search-insert-position
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

// 思考
// 遍历即可

class Solution
{

    /**
     * 二分法
     * 时间复杂度 O(logn)
     * 截止条件: 数组中只剩一个或者两个元素
     * @param $nums
     * @param $target
     * @return int
     */
    function searchInsert($nums, $target)
    {
        $len = count($nums);
        $start = 0;
        $end = $len - 1;
        while ($end - $start > 1) {
            $center = (int)(($end - $start) / 2 + $start);
            if ($nums[$center] === $target) {
                return $center;
            }

            if ($nums[$center] > $target) {
                $end = $center;
            } else {
                $start = $center;
            }
        }
        if ($target <= $nums[$start]) {
            return $start;
        }
        if ($target > $nums[$end]) {
            return $end + 1;
        }
        return $end;
    }

    /**
     * 暴力法
     * 时间复杂度 O(n)
     * @param Integer[] $nums
     * @param Integer $target
     * @return Integer
     */
    function searchInsert1($nums, $target)
    {
        $up = $nums[0] < $nums[1];
        $len = count($nums);
        if ($up) {
            if ($target <= $nums[0]) {
                return 0;
            }
            if ($target >= $nums[$len - 1]) {
                return $len;
            }
        } else {
            if ($target >= $nums[0]) {
                return 0;
            }
            if ($target <= $nums[$len - 1]) {
                return $len;
            }
        }
        for ($i = 0; $i < $len - 1; $i++) {
            if ($up && ($target >= $nums[$i] && $target <= $nums[$i + 1])) {
                return $i + 1;
            }
            if (!$up && ($target <= $nums[$i] && $target >= $nums[$i] + 1)) {
                return $i + 1;
            }
        }
    }
}

$s = new Solution();
var_dump($s->searchInsert([1, 3, 5, 6], 5)); // 2
var_dump($s->searchInsert([1, 3, 5, 6], 2)); // 1
var_dump($s->searchInsert([1, 3, 5, 6], 7)); // 4
var_dump($s->searchInsert([1, 3], 1)); // 0