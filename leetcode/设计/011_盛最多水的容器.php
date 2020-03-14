<?php

// 给你 n 个非负整数 a1，a2，...，an，每个数代表坐标中的一个点 (i, ai) 。在坐标内画 n 条垂直线，垂直线 i 的两个端点分别为 (i, ai) 和 (i, 0)。找出其中的两条线，使得它们与 x 轴共同构成的容器可以容纳最多的水。
//
//说明：你不能倾斜容器，且 n 的值至少为 2。
//
// 
//
//
//
//图中垂直线代表输入数组 [1,8,6,2,5,4,8,3,7]。在此情况下，容器能够容纳水（表示为蓝色部分）的最大值为 49。
//
// 
//
//示例：
//
//输入：[1,8,6,2,5,4,8,3,7]
//输出：49
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/container-with-most-water
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

class Solution
{

    /**
     * 双指针法
     * 控制矮的指针向高的指针移动
     * 这个方法涉及到一个原理: 双指针遍历时, 想获取更大的面积, 就必须放弃矮的一边, 向高的一边靠拢
     * 时间复杂度: O(n)
     * 空间复杂度: O(1)
     * @param $height
     * @return int|mixed
     */
    function maxArea($height)
    {
        $left = 0;
        $right = count($height) - 1;
        $maxArea = 0;
        while ($left < $right) {
            $maxArea = max(min($height[$left], $height[$right]) * ($right - $left), $maxArea);
            if ($height[$left] < $height[$right]) {
                $left++;
            } else {
                $right--;
            }
        }
        return $maxArea;
    }

    /**
     * 暴力法
     * 时间复杂度: O(n**2)
     * 空间复杂度: O(1)
     * 大量数据测试会超时
     * @param Integer[] $height
     * @return Integer
     */
    function maxArea1($height)
    {
        $max = 0;
        $len = count($height);
        for ($i = 0; $i < $len; $i++) {
            for ($j = $len - 1; $j > $i; $j--) {
                $max = max($max, ($j - $i) * min($height[$i], $height[$j]));
            }
        }
        return $max;
    }
}

$s = new Solution();

var_dump($s->maxArea([1, 8, 6, 2, 5, 4, 8, 3, 7])); // 49