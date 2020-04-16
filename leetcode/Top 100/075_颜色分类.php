<?php

// 给定一个包含红色、白色和蓝色，一共 n 个元素的数组，原地对它们进行排序，使得相同颜色的元素相邻，并按照红色、白色、蓝色顺序排列。
//
//此题中，我们使用整数 0、 1 和 2 分别表示红色、白色和蓝色。
//
//注意:
//不能使用代码库中的排序函数来解决这道题。
//
//示例:
//
//输入: [2,0,2,1,1,0]
//输出: [0,0,1,1,2,2]
//进阶：
//
//一个直观的解决方案是使用计数排序的两趟扫描算法。
//首先，迭代计算出0、1 和 2 元素的个数，然后按照0、1、2的排序，重写当前数组。
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/sort-colors
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

class Solution
{
    /**
     * 有人要求只走一趟排序, 我们想想办法
     *
     * 三路快排, 头尾指针指向0, 2, i从左到右遍历, 遇到0放表头, 遇到2放表尾
     *
     * @param $nums
     */
    function sortColors(&$nums)
    {
        $len = count($nums);
        $i = 0;
        $start = 0;
        $end = $len - 1;
        while ($i <= $end) {
            if ($nums[$i] === 0) {
                $this->swap($nums, $i, $start);
                $start++;
                $i++;
            } elseif ($nums[$i] === 2) {
                $this->swap($nums, $i, $end);
                $end--;
            } else {
                $i++;
            }
        }
    }

    function swap(&$nums, $i, $j)
    {
        $tmp = $nums[$i];
        $nums[$i] = $nums[$j];
        $nums[$j] = $tmp;
    }

    /**
     * 显然, 元素只有 1, 2, 3 三种, 我们可以使用计数排序
     * 时间复杂度: O(n + n) = O(n) 遍历了两趟
     * @param Integer[] $nums
     * @return NULL
     */
    function sortColors1(&$nums)
    {
        $sum0 = 0;
        $sum1 = 0;
        $sum2 = 0;
        $len = count($nums);
        for ($i = 0; $i < $len; $i++) {
            if ($nums[$i] === 0) {
                $sum0++;
            }
            if ($nums[$i] === 1) {
                $sum1++;
            }
            if ($nums[$i] === 2) {
                $sum2++;
            }
        }
        $n = 0;
        while ($sum0 > 0) {
            $nums[$n] = 0;
            $sum0--;
            $n++;
        }
        while ($sum1 > 0) {
            $nums[$n] = 1;
            $sum1--;
            $n++;
        }
        while ($sum2 > 0) {
            $sum2--;
            $nums[$n] = 2;
            $n++;
        }
    }
}