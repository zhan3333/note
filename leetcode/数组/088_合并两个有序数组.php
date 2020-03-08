<?php

// 给你两个有序整数数组 nums1 和 nums2，请你将 nums2 合并到 nums1 中，使 num1 成为一个有序数组。
//
// 
//
//说明:
//
//初始化 nums1 和 nums2 的元素数量分别为 m 和 n 。
//你可以假设 nums1 有足够的空间（空间大小大于或等于 m + n）来保存 nums2 中的元素。
// 
//
//示例:
//
//输入:
//nums1 = [1,2,3,0,0,0], m = 3
//nums2 = [2,5,6],       n = 3
//
//输出: [1,2,2,3,5,6]
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/merge-sorted-array
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。
//
// 思路
// 可以从数组的末尾往前排, 大的数放到 num1 的最后边

class Solution
{

    /**
     * 双指针法, 从后往前排序, 大的数字放到nums1的末尾
     * 时间复杂度 O(m + n)
     * 空间复杂度 O(1)
     * @param Integer[] $nums1
     * @param Integer $m
     * @param Integer[] $nums2
     * @param Integer $n
     * @return NULL
     */
    function merge(&$nums1, $m, $nums2, $n)
    {
        while ($m > 0 && $n > 0) {
            if ($nums1[$m - 1] >= $nums2[$n - 1]) {
                $nums1[$m + $n - 1] = $nums1[$m - 1];
                $m--;
            } else {
                $nums1[$m + $n - 1] = $nums2[$n - 1];
                $n--;
            }
        }
        while ($m > 0) {
            $nums1[$m + $n - 1] = $nums1[$m - 1];
            $m--;
        }
        while ($n > 0) {
            $nums1[$m + $n - 1] = $nums2[$n - 1];
            $n--;
        }
    }
}

$s = new Solution();

$num1 = [1, 2, 3, 0, 0, 0];
$num2 = [2, 5, 6];

$s->merge($num1, 3, $num2, 3);
var_dump($num1); // [1,2,2,3,5,6]