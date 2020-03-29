<?php

// 输入一个复杂链表（每个节点中有节点值，以及两个指针，
// 一个指向下一个节点，另一个特殊指针指向任意一个节点）
//，返回结果为复制后复杂链表的head。
//（注意，输出结果中请不要返回参数中的节点引用，
// 否则判题程序会直接返回空）


class RandomListNode
{
    var $label;
    var $next = NULL;
    var $random = NULL;

    function __construct($x)
    {
        $this->label = $x;
    }
}

function MyClone($pHead)
{
    $cur = $pHead;
    while ($cur !== null) {
        $next = $cur->next;
        $cur->next = new RandomListNode($cur->label);
        $cur->next->next = $next;
        $cur = $cur->next->next;
    }
    $cur = $pHead;
    $newList = new RandomListNode(0);
    $newCur = $newList;
    while ($cur !== null) {
        $next = $cur->next;
        if ($cur->random !== null) {
            $next->random = $cur->random->next;
        }
        $newCur->next = $next;
        $newCur = $newCur->next;
        $cur = $cur->next->next;
    }
    return $newList->next;
}

$l = new RandomListNode(1);
$l->next = new RandomListNode(2);
$l->next->next = new RandomListNode(3);
$l->next->next->next = new RandomListNode(4);
$l->next->next->next->next = new RandomListNode(5);

$l->next->random = $l;
$l->next->next->random = $l->next->next->next->next;

var_dump(MyClone($l));