<?php

// 输入一个链表，按链表从尾到头的顺序返回一个ArrayList。

class ListNode
{
    var $val;
    var $next = NULL;

    function __construct($x)
    {
        $this->val = $x;
    }
}

function printListFromTailToHead($head)
{
    $stack = [];
    $cur = $head;
    while ($cur !== null) {
        array_unshift($stack, $cur->val);
        $cur = $cur->next;
    }
    return $stack;
}

$l = new ListNode(1);
$l->next = new ListNode(2);
$l->next->next = new ListNode(3);
$l->next->next->next = new ListNode(4);
$l->next->next->next->next = new ListNode(5);

var_dump(printListFromTailToHead($l)); // 5, 4, 3, 2, 1