<?php

// 删除链表中等于给定值 val 的所有节点。
//
//示例:
//
//输入: 1->2->6->3->4->5->6, val = 6
//输出: 1->2->3->4->5

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
     * 虚拟头结点
     * @param $head
     * @param $val
     * @return null
     */
    function removeElements($head, $val)
    {
        $first = new ListNode(0);
        $first->next = $head;
        $prev = $first;
        while ($prev->next !== null) {
            if ($prev->next->val === $val) {
                $prev->next = $prev->next->next;
            } else {
                $prev = $prev->next;
            }
        }
        return $first->next;
    }

    /**
     * @param ListNode $head
     * @param Integer $val
     * @return ListNode
     */
    function removeElements1($head, $val)
    {
        while ($head !== null && $head->val === $val) {
            $head = $head->next;
        }
        if ($head === null) {
            return null;
        }
        $cur = $head;
        $prev = null;
        while ($cur !== null) {
            $next = $cur->next;
            if ($cur->val === $val) {
                $prev->next = $next;
                $cur->next = null;
            } else {
                $prev = $cur;
            }
            $cur = $next;
        }
        return $head;
    }
}

$s = new Solution();

$l = new ListNode(1);
$l->next = new ListNode(2);
$l->next->next = new ListNode(6);
$l->next->next->next = new ListNode(3);
$l->next->next->next->next = new ListNode(4);
$l->next->next->next->next->next = new ListNode(5);
$l->next->next->next->next->next->next = new ListNode(6);

var_dump($s->removeElements($l, 6)); // 1, 2, 3, 4, 5