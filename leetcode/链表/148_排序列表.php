<?php

// 在 O(n log n) 时间复杂度和常数级空间复杂度下，对链表进行排序。
//
//示例 1:
//
//输入: 4->2->1->3
//输出: 1->2->3->4
//示例 2:
//
//输入: -1->5->3->4->0
//输出: -1->0->3->4->5

class ListNode
{
    public $val = 0;
    public $next = null;

    function __construct($val)
    {
        $this->val = $val;
    }
}

/**
 * Definition for a singly-linked list.
 * class ListNode {
 *     public $val = 0;
 *     public $next = null;
 *     function __construct($val) { $this->val = $val; }
 * }
 */
class Solution
{

    /**
     * @param ListNode $head
     * @return ListNode
     */
    function sortList($head)
    {

    }
}

$l = new ListNode(-1);
$l->next = new ListNode(5);
$l->next->next = new ListNode(3);
$l->next->next->next = new ListNode(4);
$l->next->next->next->next = new ListNode(0);

$s = new Solution();

var_dump($s->sortList($l)); // -1, 0, 3, 4, 5