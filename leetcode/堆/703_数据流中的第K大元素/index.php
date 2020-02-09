<?php

// 设计一个找到数据流中第K大元素的类（class）。注意是排序后的第K大元素，不是第K个不同的元素。
// 
// 你的 KthLargest 类需要一个同时接收整数 k 和整数数组nums 的构造器，它包含数据流中的初始元素。每次调用 KthLargest.add，返回当前数据流中第K大的元素。
// 
// 示例:
// 
// int k = 3;
// int[] arr = [4,5,8,2];
// KthLargest kthLargest = new KthLargest(3, arr);
// kthLargest.add(3);   // returns 4
// kthLargest.add(5);   // returns 5
// kthLargest.add(10);  // returns 5
// kthLargest.add(9);   // returns 8
// kthLargest.add(4);   // returns 8
// 说明:
// 你可以假设 nums 的长度≥ k-1 且k ≥ 1。
// 
// 来源：力扣（LeetCode）
// 链接：https://leetcode-cn.com/problems/kth-largest-element-in-a-stream
// 著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

// 思路
// 维护一个长度为k的最小堆, 每一个数进入时, 与top比较, 如果比top还小就丢弃, 大的话就入堆
// 注意: 1. 保证堆的长度只有k, 不到k时只加入, 大于k时符合条件则替换

class KthLargest {
    private $heap;
    private $k;

    /**
     * @param Integer $k
     * @param Integer[] $nums
     */
    function __construct($k, $nums) {
        $this->k = $k;
        $this->heap = new SplMinHeap();
        foreach ($nums as $num) {
            $this->heap->insert($num);
        }
        $countNums = count($nums);
        if ($countNums > $k) {
            for($i = 0; $i < $countNums - $k; $i ++) {
                $this->heap->extract();
            }
        }
    }
  
    /**
     * @param Integer $val
     * @return Integer
     */
    function add($val) {
        if ($this->heap->count() < $this->k) {
            $this->heap->insert($val);
        } elseif ($this->heap->top() < $val) {
            // 取出top
            $this->heap->extract();
            $this->heap->insert($val);
        }
        return $this->heap->top();
    }
}

/**
 * Your KthLargest object will be instantiated and called as such:
 * $obj = KthLargest($k, $nums);
 * $ret_1 = $obj->add($val);
 */

$s = new KthLargest(3, [4,5 ,8,2]);
var_dump($s->add(3));   // 4
var_dump($s->add(10));  // 5

$s = new KthLargest(1, []);
var_dump($s->add(-3)); // -3
var_dump($s->add(-2)); // -2
var_dump($s->add(-4)); // -2
var_dump($s->add(0));  // 0
var_dump($s->add(4));  // 4
