<?php

// 给定一个整数数组  nums，求出数组从索引 i 到 j  (i ≤ j) 范围内元素的总和，包含 i,  j 两点。
//
//示例：
//
//给定 nums = [-2, 0, 3, -5, 2, -1]，求和函数为 sumRange()
//
//sumRange(0, 2) -> 1
//sumRange(2, 5) -> -1
//sumRange(0, 5) -> -3
//说明:
//
//你可以假设数组不可变。
//会多次调用 sumRange 方法。
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/range-sum-query-immutable
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

class NumArray
{

    private $len;
    // 缓存前i个数的和
    private $sums = [];

    /**
     * @param Integer[] $nums
     */
    function __construct($nums)
    {
        $this->len = count($nums);
        $sum = 0;
        for ($i = 0; $i < $this->len; $i++) {
            $sum += $nums[$i];
            $this->sums[$i] = $sum;
        }
        $this->sums[-1] = 0;
    }

    /**
     * @param Integer $i
     * @param Integer $j
     * @return Integer
     */
    function sumRange($i, $j)
    {
        if ($i > $j) {
            return 0;
        }
        if ($j > $this->len - 1) {
            return 0;
        }
        $sum = $this->sums[$j] - $this->sums[$i - 1];
        return $sum;
    }
}

/**
 * Your NumArray object will be instantiated and called as such:
 * $obj = NumArray($nums);
 * $ret_1 = $obj->sumRange($i, $j);
 */

$s = new NumArray([-2, 0, 3, -5, 2, -1]);

var_dump($s->sumRange(0, 2)); // 1
var_dump($s->sumRange(2, 5)); // -1
var_dump($s->sumRange(0, 5)); // -3