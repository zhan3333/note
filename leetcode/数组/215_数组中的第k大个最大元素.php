<?php

// 在未排序的数组中找到第 k 个最大的元素。请注意，你需要找的是数组排序后的第 k 个最大的元素，而不是第 k 个不同的元素。
//
//示例 1:
//
//输入: [3,2,1,5,6,4] 和 k = 2
//输出: 5
//示例 2:
//
//输入: [3,2,3,1,2,4,5,5,6] 和 k = 4
//输出: 4
//说明:
//
//你可以假设 k 总是有效的，且 1 ≤ k ≤ 数组的长度。
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/kth-largest-element-in-an-array
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。
//
// 思考
// 使用选择排序, 排到第k项停止


class Solution
{
    /**
     *
     * 维护一个大小为k的最小堆, 将大于堆顶的数据都放到堆中
     * 时间复杂度: O(NlogK), K 为堆的大小
     * 空间复杂度: O(k) 储存堆元素
     * @param $nums
     * @param $k
     * @return mixed
     */
    function findKthLargest2($nums, $k)
    {
        $minHeap = new SplMinHeap();
        for ($i = 0, $len = count($nums); $i < $len; $i++) {
            if ($minHeap->count() >= $k) {
                // 只替换
                if ($minHeap->top() < $nums[$i]) {
                    $minHeap->extract();
                    $minHeap->insert($nums[$i]);
                }
            } else {
                $minHeap->insert($nums[$i]);
            }
        }
        return $minHeap->top();
    }


    /**
     * 归并排序(快速排序), 每次可以减少一半的数量
     * 需要考虑到有相同的数, 只算一次排名
     * 时间复杂度: O(n), 最坏O(n**2)
     * 空间复杂度: O(1)
     * @param $nums
     * @param $k
     * @return mixed
     */
    function findKthLargest($nums, $k)
    {
        while (true) {
            if (count($nums) === 1) {
                return $nums[0];
            }
            $left = [];
            $right = [];
            $len = count($nums);
            $center = (int)($len / 2);
            for ($i = 0; $i < $len; $i++) {
                if ($i === $center) {
                    continue;
                }
                if ($nums[$i] < $nums[$center]) {
                    // 小于中间点的数
                    $right[] = $nums[$i];
                } else {
                    // 大于中间点的数
                    $left[] = $nums[$i];
                }
            }
            if ($k === count($left) + 1) {
                return $nums[$center];
            } elseif ($k < count($left) + 1) {
                // 在左边
                $nums = $left;
            } elseif ($k > count($left) + 1) {
                // 在右边, 而且已经排除了 count($left) + 1 项
                $k = $k - count($left) - 1;
                $nums = $right;
            }
        }
    }

    /**
     * 选择排序, 排到第k位即停止
     * 时间复杂度: 平均 O(n), 最坏 O(n^2)
     * 空间复杂度: O(1)
     * @param Integer[] $nums
     * @param Integer $k
     * @return Integer
     */
    function findKthLargest1($nums, $k)
    {
        $len = count($nums);
        for ($i = 0; $i < $k; $i++) {
            for ($j = $i + 1; $j < $len; $j++) {
                if ($nums[$j] > $nums[$i]) {
                    $temp = $nums[$j];
                    $nums[$j] = $nums[$i];
                    $nums[$i] = $temp;
                }
            }
        }
        return $nums[$k - 1];
    }
}

$s = new Solution();

var_dump($s->findKthLargest([3, 2, 1, 5, 6, 4], 2)); // 5
var_dump($s->findKthLargest([1, 2], 2)); // 1
var_dump($s->findKthLargest([3, 2, 3, 1, 2, 4, 5, 5, 6], 4)); // 4