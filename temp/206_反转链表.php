<?php


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

    function reverseList($head)
    {
        return $this->reverse($head);
    }

    function reverse($head)
    {
        if ($head === null || $head->next === null) {
            return $head;
        }
        $node = $this->reverse($head->next);
        $head->next->next = $head;
        $head->next = null;
        return $node;
    }

    /**
     * @param ListNode $head
     * @return ListNode
     */
    function reverseList1($head)
    {
        if ($head === null) {
            return null;
        }
        $prev = null;
        $cur = $head;
        while ($cur !== null) {
            $next = $cur->next;
            $cur->next = $prev;
            $prev = $cur;
            $cur = $next;
        }
        return $prev;
    }
}

$l = new ListNode(1);
$l->next = new ListNode(2);
$l->next->next = new ListNode(3);
$l->next->next->next = new ListNode(4);
$l->next->next->next->next = new ListNode(5);

$s = new Solution();

var_dump($s->reverseList($l)); // 5, 4, 3, 2, 1