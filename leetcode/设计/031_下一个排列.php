<?php

// 实现获取下一个排列的函数，算法需要将给定数字序列重新排列成字典序中下一个更大的排列。
//
//如果不存在下一个更大的排列，则将数字重新排列成最小的排列（即升序排列）。
//
//必须原地修改，只允许使用额外常数空间。
//
//以下是一些例子，输入位于左侧列，其相应输出位于右侧列。
//1,2,3 → 1,3,2
//3,2,1 → 1,2,3
//1,1,5 → 1,5,1
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/next-permutation
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

class Solution
{

    /**
     * @param Integer[] $nums
     * @return NULL
     */
    function nextPermutation(&$nums)
    {
        $len = count($nums);
        $i = $len - 1;
        while ($i > 0) {
            if ($nums[$i] > $nums[$i - 1]) {
                // 找到 i -> len - 1 之间最小的数, 来和 i-1 交换
                // 由于 i -> len -1 是有序递增的, 所以从末尾找到的第一个大于 nums[i-1] 的数就是最小的数
                $j = $len - 1;
                while ($j >= $i) {
                    if ($nums[$j] > $nums[$i - 1]) {
                        break;
                    }
                    $j--;
                }
                $tmp = $nums[$i - 1];
                $nums[$i - 1] = $nums[$j];
                $nums[$j] = $tmp;
                // 升序排序 i -> len - 1
                for ($m = $i + 1; $m < $len; $m++) {
                    for ($n = $m; $n > $i; $n--) {
                        if ($nums[$n] < $nums[$n - 1]) {
                            $tmp = $nums[$n];
                            $nums[$n] = $nums[$n - 1];
                            $nums[$n - 1] = $tmp;
                        }
                    }
                }
                return;
            }
            $i--;
        }
        sort($nums);
    }
}

$s = new Solution();

$nums = [1, 2, 3];

$s->nextPermutation($nums);

var_dump($nums); // 1, 3, 2

$s->nextPermutation($nums);

var_dump($nums); // 2, 1, 3

$s->nextPermutation($nums);

var_dump($nums); // 2, 3, 1

$s->nextPermutation($nums);

var_dump($nums); // 3, 1, 2

$s->nextPermutation($nums);

var_dump($nums); // 3, 2, 1

$s->nextPermutation($nums);

var_dump($nums); // 1, 2, 3
