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
     * @param Integer[] $nums
     * @return NULL
     */
    function moveZeroes(&$nums)
    {
        $len = count($nums);
        $lastNonZeroFoundAt = 0;
        for ($cur = 0; $cur < $len; $cur++) {
            if ($nums[$cur] !== 0) {
                $tmp = $nums[$cur];
                $nums[$cur] = $nums[$lastNonZeroFoundAt];
                $nums[$lastNonZeroFoundAt] = $tmp;
                $lastNonZeroFoundAt++;
            }
        }
    }
}

$s = new Solution();

$nums = [0, 1, 0, 2];
$s->moveZeroes($nums);
var_dump($nums); // 1, 2, 0, 0

$nums = [0, 0, 1];
$s->moveZeroes($nums);
var_dump($nums); // 1, 0, 0

$nums = [1];
$s->moveZeroes($nums);
var_dump($nums); // 1


$nums = [1, 0, 1];
$s->moveZeroes($nums);
var_dump($nums); // 1