<?php

// 给定一个数组 nums，编写一个函数将所有 0 移动到数组的末尾，同时保持非零元素的相对顺序。
//
//示例:
//
//输入: [0,1,0,3,12]
//输出: [1,3,12,0,0]
//说明:
//
//必须在原数组上操作，不能拷贝额外的数组。
//尽量减少操作次数。
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/move-zeroes
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

class Solution
{
    /**
     * 下面做法的优化, 减少了一次将 j 后边的数置0的操作
     * @param $nums
     */
    function moveZeroes(&$nums)
    {
        $len = count($nums);
        $i = 0;
        $j = 0;
        for (; $i < $len; $i++) {
            if ($nums[$i] !== 0) {
                $nums[$j] = $nums[$i];
                if ($i !== $j) {
                    $nums[$i] = 0;
                }
                $j++;
            }
        }
    }


    /**
     * 从左往右, i为计数器, j为每一个非0数应该放的地方.
     * i 到末尾时, j以后的数都为0
     * 双指针, 同时从开头走, 遇到0时j被留下, 遇到非0时, i,j 互换值
     * @param $nums
     */
    function moveZeroes2(&$nums)
    {
        $len = count($nums);
        $i = 0;
        $j = 0;
        for (; $i < $len; $i++) {
            if ($nums[$i] !== 0) {
                $nums[$j++] = $nums[$i];
            }
        }
        while ($j < $len) {
            $nums[$j++] = 0;
        }
    }


    /**
     * 使用冒泡排序
     * 优化1: 记录最后一个交换的位置, 作为下一轮的截止点
     * @param Integer[] $nums
     * @return NULL
     */
    function moveZeroes1(&$nums)
    {
        $len = count($nums);
        $lastSwapIndex = $len - 2;
        for ($i = 0; $i < $len; $i++) {
            $end = $lastSwapIndex;
            for ($j = $i; $j <= $end; $j++) {
                if ($nums[$j] === 0) {
                    $tmp = $nums[$j];
                    $nums[$j] = $nums[$j + 1];
                    $nums[$j + 1] = $tmp;
                    $lastSwapIndex = $j - 1;
                }
            }
        }
    }
}