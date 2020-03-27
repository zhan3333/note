<?php

// 输入两个单调递增的链表，输出两个链表合成后的链表，当然我们需要合成后的链表满足单调不减规则。


class ListNode
{
    var $val;
    var $next = NULL;

    function __construct($x)
    {
        $this->val = $x;
    }
}

function Merge($pHead1, $pHead2)
{
    if ($pHead2->val < $pHead1->val) {
        $tmp = $pHead1;
        $pHead1 = $pHead2;
        $pHead2 = $tmp;
    }
    $c1 = $pHead1;
    $c2 = $pHead2;
    $newList = new ListNode(0);
    $c3 = $newList;
    while ($c1 !== null || $c2 !== null) {
        if ($c1 === null) {
            while ($c2 !== null) {
                $c3->next = $c2;
                $c2 = $c2->next;
                $c3 = $c3->next;
            }
        } elseif ($c2 === null) {
            while ($c1 !== null) {
                $c3->next = $c1;
                $c1 = $c1->next;
                $c3 = $c3->next;
            }
        } else {
            if ($c1->val < $c2->val) {
                $c3->next = $c1;
                $c1 = $c1->next;
            } else {
                $c3->next = $c2;
                $c2 = $c2->next;
            }
            $c3 = $c3->next;
        }
    }
    return $newList->next;
}

$l1 = new ListNode(1);
$l1->next = new ListNode(3);
$l1->next->next = new ListNode(5);
$l1->next->next->next = new ListNode(7);


$l2 = new ListNode(2);
$l2->next = new ListNode(4);
$l2->next->next = new ListNode(6);
$l2->next->next->next = new ListNode(8);

var_dump(Merge($l1, $l2)); // 1, 2, 3, 4, 5, 6