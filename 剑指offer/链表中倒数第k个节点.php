<?php

// 输入一个链表，输出该链表中倒数第k个结点。


class ListNode
{
    var $val;
    var $next = NULL;

    function __construct($x)
    {
        $this->val = $x;
    }
}

function FindKthToTail($head, $k)
{
    if (empty($head) || $k < 1) {
        return null;
    }
    $fast = $head;
    $n = $k - 1;
    while ($n > 0) {
        $fast = $fast->next;
        if ($fast === null) {
            return null;
        }
        $n--;
    }
    $slow = $head;
    while ($fast->next !== null) {
        $fast = $fast->next;
        $slow = $slow->next;
    }
    return $slow;
}

$l = new ListNode(1);

$l->next = new ListNode(2);
$l->next->next = new ListNode(3);
$l->next->next->next = new ListNode(4);
$l->next->next->next->next = new ListNode(5);

var_dump(FindKthToTail($l, 3)); // 3
var_dump(FindKthToTail($l, 5)); // 1, 2, 3, 4, 5
