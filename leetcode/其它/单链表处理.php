<?php

// 假设线性表 L = {A1, A2, A3, A4, …, An-2, An-1, An}，采⽤带头节点的单链表保存。链接节点定义如
//下：
//typedef struct node {
//int data;
//struct node * next;
//} NODE;
//请设计⼀个算法，编程实现，重新排列 L 中的各节点，得到线性表 L’ = {A1, An, A2, An-1, A3, An2, … }。

class ListNode
{
    public $data = null;
    /** @var ListNode */
    public $next = null;

    public function __construct($data)
    {
        $this->data = $data;
    }
}

Class Solution
{
    /**
     * @param ListNode $head
     * @return ListNode
     */
    function singleListProcess($head)
    {
        if ($head === null || $head->next === null) {
            return $head;
        }
        $fast = $head;
        $slow = $head;
        while ($fast !== null && $fast->next !== null) {
            $fast = $fast->next->next;
            $slow = $slow->next;
        }
        $left = $head;
        $right = $slow->next;   // 设置 right
        $slow->next = null;  // left 断开连接
        $rightCur = $right;
        // 反转 right
        $prev = null;
        while ($rightCur !== null) {
            $next = $rightCur->next;
            $rightCur->next = $prev;
            $prev = $rightCur;
            $rightCur = $next;
        }
        $reverseRight = $prev;
        // 开始插入
        $leftCur = $left;
        $rightCur = $reverseRight;
        while ($rightCur !== null) {
            $lNext = $leftCur->next;
            $rNext = $rightCur->next;
            $leftCur->next = $rightCur;
            $rightCur->next = $lNext;
            $leftCur = $lNext;
            $rightCur = $rNext;
        }
        return $left;
    }
}

$l = new ListNode(1);
$l->next = new ListNode(2);
$l->next->next = new ListNode(3);
$l->next->next->next = new ListNode(4);
$l->next->next->next->next = new ListNode(5);
$l->next->next->next->next->next = new ListNode(6);
$l->next->next->next->next->next->next = new ListNode(7);

// 多节点测试
$s = new Solution();
var_dump($s->singleListProcess($l));

// null 测试
var_dump($s->singleListProcess(null));

// 单个节点测试
$l2 = new ListNode(1);
var_dump($s->singleListProcess($l2));

// 两个节点测试
$l3 = new ListNode(1);
$l3->next = new ListNode(2);
var_dump($s->singleListProcess($l3));
