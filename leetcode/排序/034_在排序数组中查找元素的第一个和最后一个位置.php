<?php

// 给定一个按照升序排列的整数数组 nums，和一个目标值 target。找出给定目标值在数组中的开始位置和结束位置。
//
//你的算法时间复杂度必须是 O(log n) 级别。
//
//如果数组中不存在目标值，返回 [-1, -1]。
//
//示例 1:
//
//输入: nums = [5,7,7,8,8,10], target = 8
//输出: [3,4]
//示例 2:
//
//输入: nums = [5,7,7,8,8,10], target = 6
//输出: [-1,-1]
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/find-first-and-last-position-of-element-in-sorted-array
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

class Solution
{

    function searchRange($nums, $target)
    {
        $left = 0;
        $right = count($nums) - 1;
        while ($left < $right) {
            $center = (int)(($right - $left) / 2) + $left;
            if ($nums[$center] === $target) {
                $right = $center;
            } elseif ($nums[$center] > $target) {
                $right = $center - 1;
            } else {
                $left = $center + 1;
            }
        }
        if ($nums[$left] !== $target) {
            return [-1, -1];
        }
        $startPoint = $left;
        $right = count($nums) - 1;
        while ($left < $right) {
            $center = (int)(($right - $left) / 2) + $left;
            if ($nums[$center] === $target) {
                if ($left === $center) {
                    // 只剩两个数了
                    if ($nums[$right] === $target) {
                        return [$startPoint, $right];
                    }
                    $right = $center;
                }
                $left = $center;
            } elseif ($nums[$center] > $target) {
                $right = $center - 1;
            } else {
                $left = $center + 1;
            }
        }
        return [$startPoint, $right];
    }

    /**
     * 二分法查找, 时间复杂度 O(logN)
     * @param Integer[] $nums
     * @param Integer $target
     * @return Integer[]
     */
    function searchRange2($nums, $target)
    {
        return [$this->findFirst($nums, $target), $this->findLast($nums, $target)];
    }

    function findFirst($nums, $target)
    {
        $left = 0;
        $right = count($nums) - 1;
        while ($left < $right) {
            $center = (int)(($right - $left) / 2) + $left;
            if ($nums[$center] === $target) {
                $right = $center;
            } elseif ($nums[$center] > $target) {
                $right = $center - 1;
            } else {
                $left = $center + 1;
            }
        }
        return $nums[$left] === $target ? $left : -1;
    }

    function findLast($nums, $target)
    {
        $left = 0;
        $right = count($nums) - 1;
        while ($left < $right) {
            $center = (int)(($right - $left) / 2) + $left;
            if ($nums[$center] === $target) {
                if ($left === $center) {
                    // 只剩两个数的情况
                    if ($nums[$right] === $target) {
                        return $right;
                    }
                    $right = $center;
                } else {
                    $left = $center;
                }
            } elseif ($nums[$center] > $target) {
                $right = $center - 1;
            } else {
                $left = $center + 1;
            }
        }
        return $nums[$right] === $target ? $right : -1;
    }
}

$s = new Solution();

var_dump($s->searchRange([5, 7, 7, 8, 8, 10], 8));  // [3, 4]
var_dump($s->searchRange([5, 7, 7, 8, 8, 10], 6));  // [-1, -1]
var_dump($s->searchRange([2, 2], 2));  // [-1, -1]

