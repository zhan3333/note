<?php

// 输入一个链表，反转链表后，输出新链表的表头。


class ListNode
{
    var $val;
    var $next = NULL;

    function __construct($x)
    {
        $this->val = $x;
    }
}

function ReverseList($pHead)
{
    $next = null;
    $cur = $pHead;
    while ($cur !== null) {
        $temp = $cur->next;
        $cur->next = $next;
        $next = $cur;
        $cur = $temp;
    }
    return $next;
}

$l = new ListNode(1);
$l->next = new ListNode(2);
$l->next->next = new ListNode(3);

var_dump(ReverseList($l)); // 3, 2, 1