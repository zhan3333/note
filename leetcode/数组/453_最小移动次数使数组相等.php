<?php

// 给定一个长度为 n 的非空整数数组，找到让数组所有元素相等的最小移动次数。每次移动可以使 n - 1 个元素增加 1。
//
//示例:
//
//输入:
//[1,2,3]
//
//输出:
//3
//
//解释:
//只需要3次移动（注意每次移动会增加两个元素的值）：
//
//[1,2,3]  =>  [2,3,3]  =>  [3,4,3]  =>  [4,4,4]
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/minimum-moves-to-equal-array-elements
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

class Solution
{

    /**
     * 数学办法, n-1 个数加1 相当于 1个数减1
     * 时间复杂度: O(n)
     * 空间复杂度: O(1)
     * @param Integer[] $nums
     * @return Integer
     */
    function minMoves($nums)
    {
        $min = min($nums);
        $len = count($nums);
        $count = 0;
        for ($i = 0; $i < $len; $i++) {
            if ($nums[$i] !== $min) {
                $count += $nums[$i] - $min;
            }
        }
        return $count;
    }
}

$s = new Solution();
var_dump($s->minMoves([1, 2, 3])); // 3