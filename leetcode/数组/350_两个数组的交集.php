<?php

// 给定两个数组，编写一个函数来计算它们的交集。
//
//示例 1:
//
//输入: nums1 = [1,2,2,1], nums2 = [2,2]
//输出: [2,2]
//示例 2:
//
//输入: nums1 = [4,9,5], nums2 = [9,4,9,8,4]
//输出: [4,9]
//说明：
//
//输出结果中每个元素出现的次数，应与元素在两个数组中出现的次数一致。
//我们可以不考虑输出结果的顺序。
//进阶:
//
//如果给定的数组已经排好序呢？你将如何优化你的算法？
//如果 nums1 的大小比 nums2 小很多，哪种方法更优？
//如果 nums2 的元素存储在磁盘上，磁盘内存是有限的，并且你不能一次加载所有的元素到内存中，你该怎么办？
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/intersection-of-two-arrays-ii
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

class Solution
{

    /**
     * hash 表储存结果
     *
     * 时间复杂度: O(m + n)
     * 空间复杂度: O(min(m, n))
     *
     * 1. 如果给定的数组有序如何优化?
     * 有序的话可以使用双指针的方式查询, 时间复杂度一样是 O(m + n), 但是不需要额外空间
     *
     * 2. 如果 nums1 的大小比 nums2 小很多, 哪种方法更优?
     * hash对小的数组进行hash, 可以节约内存
     *
     * 3. 如果 nums2 的元素储存在磁盘上, 磁盘内存是有限的, 并且你不能一次加载所有的元素到内存中, 该怎么办
     * num1 已经在内存中了, 那么hash计数 num1, 然后逐段读取 nums2 的元素, 进行判断.
     *
     * @param Integer[] $nums1
     * @param Integer[] $nums2
     * @return Integer[]
     */
    function intersect($nums1, $nums2)
    {
        if (count($nums1) > count($nums2)) {
            $tmp = $nums1;
            $nums1 = $nums2;
            $nums2 = $tmp;
        }
        $ans = [];
        $len1 = count($nums1);
        $len2 = count($nums2);
        $hash = [];
        for ($i = 0; $i < $len1; $i++) {
            if (!isset($hash[$nums1[$i]])) {
                $hash[$nums1[$i]] = 0;
            }
            $hash[$nums1[$i]]++;
        }
        for ($i = 0; $i < $len2; $i++) {
            if (isset($hash[$nums2[$i]])) {
                $hash[$nums2[$i]]--;
                $ans[] = $nums2[$i];
                if ($hash[$nums2[$i]] === 0) {
                    unset($hash[$nums2[$i]]);
                }
            }
        }
        return $ans;
    }
}

$s = new Solution();

var_dump($s->intersect([1, 2, 2, 1], [2, 2])); // 2, 2