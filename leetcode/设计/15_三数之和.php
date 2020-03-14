<?php

// 给你一个包含 n 个整数的数组 nums，判断 nums 中是否存在三个元素 a，b，c ，使得 a + b + c = 0 ？请你找出所有满足条件且不重复的三元组。
//
//注意：答案中不可以包含重复的三元组。
//
// 
//
//示例：
//
//给定数组 nums = [-1, 0, 1, 2, -1, -4]，
//
//满足要求的三元组集合为：
//[
//  [-1, 0, 1],
//  [-1, -1, 2]
//]
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/3sum
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

//

class Solution
{

    /**
     * 三指针方法
     * 时间复杂度: O(n**2) = 排序数组O(NlogN) + 循环*双指针遍历 O(n) * O(n)
     * 空间复杂度: O(1)
     * @param Integer[] $nums
     * @return Integer[][]
     */
    function threeSum($nums)
    {
        $len = count($nums);
        $res = [];
        if ($len < 3) {
            return [];
        }
        sort($nums);
        for ($i = 0; $i < $len; $i++) {
            if ($nums[$i] > 0) {
                return $res;
            }
            if ($i > 0 && $nums[$i] === $nums[$i - 1]) {
                continue;
            }
            $l = $i + 1;
            $r = $len - 1;
            while ($l < $r) {
                if ($nums[$i] + $nums[$l] + $nums[$r] === 0) {
                    $res[] = [$nums[$i], $nums[$l], $nums[$r]];
                    while ($l < $r && $nums[$l] === $nums[$l + 1]) {
                        $l++;
                    }
                    while ($l < $r && $nums[$r] === $nums[$r - 1]) {
                        $r--;
                    }
                    $l++;
                    $r--;
                } elseif ($nums[$i] + $nums[$l] + $nums[$r] < 0) {
                    $l++;
                } else {
                    $r--;
                }
            }
        }
        return $res;
    }

}

$s = new Solution();

//[
//  [-1, 0, 1],
//  [-1, -1, 2]
//]
var_dump($s->threeSum([-1, 0, 1, 2, -1, -4]));