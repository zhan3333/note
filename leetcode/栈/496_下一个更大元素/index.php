<?php

//给定两个没有重复元素的数组 nums1 和 nums2 ，其中nums1 是 nums2 的子集。找到 nums1 中每个元素在 nums2 中的下一个比其大的值。
//
//nums1 中数字 x 的下一个更大元素是指 x 在 nums2 中对应位置的右边的第一个比 x 大的元素。如果不存在，对应位置输出-1。
//
//示例 1:
//
//输入: nums1 = [4,1,2], nums2 = [1,3,4,2].
//输出: [-1,3,-1]
//解释:
//    对于num1中的数字4，你无法在第二个数组中找到下一个更大的数字，因此输出 -1。
//    对于num1中的数字1，第二个数组中数字1右边的下一个较大数字是 3。
//    对于num1中的数字2，第二个数组中没有下一个更大的数字，因此输出 -1。
//示例 2:
//
//输入: nums1 = [2,4], nums2 = [1,2,3,4].
//输出: [3,-1]
//解释:
//    对于num1中的数字2，第二个数组中的下一个较大数字是3。
//    对于num1中的数字4，第二个数组中没有下一个更大的数字，因此输出 -1。
//注意:
//
//nums1和nums2中所有元素是唯一的。
//nums1和nums2 的数组大小都不超过1000。
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/next-greater-element-i
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

// 思路
// 使用单调栈, nums2的第一个数放到栈中, 遍历nums2, 遇到比栈顶小的数就入栈, 遇到比栈顶的数, 就循环出栈, 出栈数<当前数就存hash
// 然后循环nums1数组, 判断在不在hash的key中, 在就输出value, 不在就输出-1
// 注意
// 当前数一定需要入栈
// 遇到当前数大于栈顶, 需要对栈中的数一个个进行检查是否都小于当前数, 小于的话都得出栈并存hash

class Solution {

    /**
     * @param Integer[] $nums1
     * @param Integer[] $nums2
     * @return Integer[]
     */
    function nextGreaterElement($nums1, $nums2) {
        $stack = new SplStack();
        $hash = [];
        $stack->push($nums2[0]);
        for ($i = 1, $count = count($nums2); $i < $count; $i ++) {
            $cur = $nums2[$i];
            if ($stack->top() < $cur) {
                while (!$stack->isEmpty() && $stack->top() < $cur) {
                    $hash[$stack->pop()] = $cur;
                }
            }
            $stack->push($cur);
        }
        $result = [];
        foreach ($nums1 as $item) {
            $result[] = $hash[$item] ?? -1;
        }
        return $result;
    }
}

$solution = new Solution();
var_dump($solution->nextGreaterElement([4, 1, 2], [1, 3, 4, 2])); // -1, 3, -1