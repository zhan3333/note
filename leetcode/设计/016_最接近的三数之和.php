<?php

// 给定一个包括 n 个整数的数组 nums 和 一个目标值 target。找出 nums 中的三个整数，使得它们的和与 target 最接近。返回这三个数的和。假定每组输入只存在唯一答案。
//
//例如，给定数组 nums = [-1，2，1，-4], 和 target = 1.
//
//与 target 最接近的三个数的和为 2. (-1 + 2 + 1 = 2).
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/3sum-closest
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

class Solution
{

    /**
     * 时间复杂度: O(n**2)
     * 空间复杂度: O(1)
     * @param Integer[] $nums
     * @param Integer $target
     * @return Integer
     */
    function threeSumClosest($nums, $target)
    {
        // O(NlogN) 复杂度
        sort($nums);
        $len = count($nums);
        $minDiff = PHP_INT_MAX;
        $sum = 0;
        // O(n)
        for ($i = 0; $i < $len; $i++) {
            $left = $i + 1;
            $right = $len - 1;
            // O(n)
            while ($left < $right) {
                $mark = $nums[$i] + $nums[$left] + $nums[$right];
                $oldDiff = $minDiff;
                $minDiff = min($minDiff, abs($mark - $target));
                if ($minDiff !== $oldDiff) {
                    $sum = $mark;
                }
                if ($mark > $target) {
                    $right--;
                } elseif ($mark < $target) {
                    $left++;
                } else {
                    return $mark;
                }
            }
        }
        return $sum;
    }
}

$s = new Solution();

var_dump($s->threeSumClosest([-1, 2, 1, -4], 1)); // 2 (-1 + 2 + 1 = 2)
var_dump($s->threeSumClosest([-1, 2, 1, -4], -1)); // 2 (-4 + 2 + 1 = -1)