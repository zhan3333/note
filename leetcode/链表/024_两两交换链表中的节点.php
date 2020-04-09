<?php

// 给定一个链表，两两交换其中相邻的节点，并返回交换后的链表。
//
//你不能只是单纯的改变节点内部的值，而是需要实际的进行节点交换。
//
// 
//
//示例:
//
//给定 1->2->3->4, 你应该返回 2->1->4->3.
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/swap-nodes-in-pairs
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

class ListNode
{
    public $val = 0;
    public $next = null;

    function __construct($val)
    {
        $this->val = $val;
    }
}

class Solution
{

    /**
     * 迭代交换两个节点, 难点在于一次转换需要涉及到 prev, cur, next 三个节点的操作
     * 好理解一些的做法是设置一个 dummy 虚拟节点在头部之前
     *
     * @param ListNode $head
     * @return ListNode
     */
    function swapPairs($head)
    {
        if ($head === null || $head->next === null) {
            return $head;
        }
        $cur = $head;
        $dummy = new ListNode(-1);
        $dummy->next = $cur;
        $prev = $dummy;
        while ($cur !== null && $cur->next !== null) {
            $next = $cur->next;
            $cur->next = $next->next;
            $next->next = $cur;
            $prev->next = $next;
            $prev = $cur;
            $cur = $cur->next;
        }
        return $dummy->next;
    }
}

$s = new Solution();

$head = new ListNode(1);
$head->next = new ListNode(2);
$head->next->next = new ListNode(3);
$head->next->next->next = new ListNode(4);

var_dump($s->swapPairs($head)); // 2 -> 1 -> 4 -> 3