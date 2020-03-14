<?php

// 假设按照升序排序的数组在预先未知的某个点上进行了旋转。
//
//( 例如，数组 [0,1,2,4,5,6,7] 可能变为 [4,5,6,7,0,1,2] )。
//
//搜索一个给定的目标值，如果数组中存在这个目标值，则返回它的索引，否则返回 -1 。
//
//你可以假设数组中不存在重复的元素。
//
//你的算法时间复杂度必须是 O(log n) 级别。
//
//示例 1:
//
//输入: nums = [4,5,6,7,0,1,2], target = 0
//输出: 4
//示例 2:
//
//输入: nums = [4,5,6,7,0,1,2], target = 3
//输出: -1
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/search-in-rotated-sorted-array
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

class Solution
{
    /**
     * 利用旋转排序数组的特性, 取中点, 先减后增说明右边是有序的, 先增后减说明左边是有序的
     * 时间复杂度: O(logN)
     * 空间复杂度: O(1)
     * @param $nums
     * @param $target
     * @return int
     */
    function search($nums, $target)
    {
        $left = 0;
        $right = count($nums) - 1;
        while ($left <= $right) {
            $center = (int)($left + ($right - $left) / 2);
            if ($nums[$center] === $target) {
                return $center;
            }
            if ($nums[$left] === $target) {
                return $left;
            }
            if ($nums[$right] === $target) {
                return $right;
            }
            if ($nums[$left] < $nums[$center]) {
                // 升序
                if ($target > $nums[$left] && $target < $nums[$center]) {
                    $right = $center - 1;
                } else {
                    $left = $center + 1;
                }
            } else {
                // 降序
                if ($target > $nums[$center] && $target < $nums[$right]) {
                    $right = $center - 1;
                } else {
                    $left = $center + 1;
                }
            }
        }
        return -1;
    }

    /**
     * 找到旋转点, 修复数组, 然后二分查找
     * 时间复杂度: O(n) = O(n) + O(logN)
     * @param Integer[] $nums
     * @param Integer $target
     * @return Integer
     */
    function search1($nums, $target)
    {
        $len = count($nums);
        // 寻找旋转点 O(n)
        $n = 0;
        for ($i = 1; $i < $len; $i++) {
            if ($nums[$i] < $nums[$i - 1]) {
                // 找到了i为旋转点
                $n = $i;
                break;
            }
        }
        // 从旋转点二分查找
        $tmpN = $len - $n;
        while ($tmpN > 0) {
            $tmpN--;
            $pop = array_pop($nums);
            array_unshift($nums, $pop);
        }
        // 二分查找 O(logN)
        $left = 0;
        $right = $len - 1;
        while ($left <= $right) {
            $center = (int)($left + ($right - $left) / 2);
            if ($nums[$center] === $target) {
                return ($center + $n) % $len;
            } elseif ($target > $nums[$center]) {
                $left = $center + 1;
            } else {
                $right = $center - 1;
            }
        }
        return -1;
    }
}

$s = new Solution();

var_dump($s->search([4, 5, 6, 7, 0, 1, 2], 0)); // 4
var_dump($s->search([4, 5, 6, 7, 0, 1, 2], 3)); // -1
