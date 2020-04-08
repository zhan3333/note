<?php

// 给定一个包含 n 个整数的数组 nums 和一个目标值 target，判断 nums 中是否存在四个元素 a，b，c 和 d ，使得 a + b + c + d 的值与 target 相等？找出所有满足条件且不重复的四元组。
//
//注意：
//
//答案中不可以包含重复的四元组。
//
//示例：
//
//给定数组 nums = [1, 0, -1, 0, -2, 2]，和 target = 0。
//
//满足要求的四元组集合为：
//[
//  [-1,  0, 0, 1],
//  [-2, -1, 1, 2],
//  [-2,  0, 0, 2]
//]
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/4sum
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。


class Solution
{

    /**
     * 指针法求解
     * 时间复杂度: O(n^3)
     * 实质上将最后的两数之和变为双指针达到 O(n) 的查找时间复杂度, 比暴力法减少一个n
     * @param $nums
     * @param $target
     * @return array
     */
    function fourSum($nums, $target)
    {
        $len = count($nums);
        if ($len < 4) {
            return [];
        }
        sort($nums);
        $ans = [];
        for ($a = 0; $a < $len - 3; $a++) {
            if ($a > 0 && $nums[$a] === $nums[$a - 1]) {
                // 遇到了连续相同的数, 可以跳过这一个
                continue;
            }
            for ($b = $a + 1; $b < $len - 2; $b++) {
                if ($b > $a + 1 && $nums[$b] === $nums[$b - 1]) {
                    // 遇到与前一个数相同的, 没有必要加入查找中
                    continue;
                }
                $c = $b + 1;
                $d = $len - 1;
                while ($c < $d) {
                    $sum = $nums[$a] + $nums[$b] + $nums[$c] + $nums[$d];
                    if ($sum < $target) {
                        while ($c < $d && $nums[$c] === $nums[++$c]) {
                        }
                    } elseif ($sum > $target) {
                        while ($c < $d && $nums[$d] === $nums[--$d]) {
                        }
                    } else {
                        $ans[] = [$nums[$a], $nums[$b], $nums[$c], $nums[$d]];
                        while ($c < $d && $nums[$c] === $nums[++$c]) {
                        }
                        while ($c < $d && $nums[$d] === $nums[--$d]) {
                        }
                    }
                }
            }
        }
        return $ans;
    }

    /**
     * 暴力回溯法求解....
     * 时间复杂度: O(n^4) 每层遍历一次数组, 一共四层
     * @param Integer[] $nums
     * @param Integer $target
     * @return Integer[][]
     */
    function fourSum1($nums, $target)
    {
        if (count($nums) < 4) {
            return [];
        }
        $path = [];
        $ans = [];
        $this->backtrack($nums, $target, $path, $ans);
        return $ans;
    }

    function backtrack($nums, $target, $path, &$ans)
    {
        $values = array_map(function ($item) {
            return $item[1];
        }, $path);
        $sum = array_sum($values);
        $useIndexes = array_map(function ($item) {
            return $item[0];
        }, $path);
        if (count($path) === 4) {
            sort($values);
            if ($sum === $target && !in_array($values, $ans, false)) {
                $ans[] = $values;
            }
            return;
        }
        $len = count($nums);
        for ($i = 0; $i < $len; $i++) {
            if (!in_array($i, $useIndexes, true)) {
                $path[] = [$i, $nums[$i]];
                $this->backtrack($nums, $target, $path, $ans);
                array_pop($path);
            }
        }
    }
}

$s = new Solution();

// [
//  [-1,  0, 0, 1],
//  [-2, -1, 1, 2],
//  [-2,  0, 0, 2]
//]
var_dump($s->fourSum([1, 0, -1, 0, -2, 2], 0));