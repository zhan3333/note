<?php

// 给定两个数组，编写一个函数来计算它们的交集。
//
//示例 1:
//
//输入: nums1 = [1,2,2,1], nums2 = [2,2]
//输出: [2]
//示例 2:
//
//输入: nums1 = [4,9,5], nums2 = [9,4,9,8,4]
//输出: [9,4]
//说明:
//
//输出结果中的每个元素一定是唯一的。
//我们可以不考虑输出结果的顺序。
//
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/intersection-of-two-arrays
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

class Solution
{
    /**
     * PHP 需要安装 Ds 扩展才有 set 用, 在此之前就用 array 模拟 set 来操作队了
     * @param Integer[] $nums1
     * @param Integer[] $nums2
     * @return Integer[]
     */
    function intersection($nums1, $nums2)
    {
        $map = [];
        $len1 = count($nums1);
        $len2 = count($nums2);
        $ans = [];
        for ($i = 0; $i < $len1; $i++) {
            $map[$nums1[$i]] = true;
        }
        for ($i = 0; $i < $len2; $i++) {
            if (isset($map[$nums2[$i]])) {
                $ans[] = $nums2[$i];
                unset($map[$nums2[$i]]);
            }
        }
        return $ans;
    }
}

$s = new Solution();

var_dump($s->intersection([1, 2, 2, 1], [2, 2])); // 2