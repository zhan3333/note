<?php

//给出两个 非空 的链表用来表示两个非负的整数。其中，它们各自的位数是按照 逆序 的方式存储的，并且它们的每个节点只能存储 一位 数字。
//
//如果，我们将这两个数相加起来，则会返回一个新的链表来表示它们的和。
//
//您可以假设除了数字 0 之外，这两个数都不会以 0 开头。
//
//示例：
//
//输入：(2 -> 4 -> 3) + (5 -> 6 -> 4)
//输出：7 -> 0 -> 8
//原因：342 + 465 = 807
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/add-two-numbers
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

// 思考
// 这道题已经帮我们做好了逆序储存的链表, 从低位往高位加, 所以只需要一次while来进行相加进位

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
     * @param ListNode $l1
     * @param ListNode $l2
     * @return ListNode
     */
    function addTwoNumbers($l1, $l2)
    {
        $l3 = new ListNode(0);
        $l3Cur = $l3;
        $up = 0;
        while ($l1 !== null || $l2 !== null || $up !== 0) {
            $l1Val = $l1 === null ? 0 : $l1->val;
            $l2Val = $l2 === null ? 0 : $l2->val;
            $sumVal = $l1Val + $l2Val + $up;
            $up = $sumVal / 10 >= 1 ? 1 : 0;
            $sumNode = new ListNode($sumVal % 10);
            $l3Cur->next = $sumNode;
            // 这一行是为什么: cur 相当于链表中的指针, 这里是将指针指向了下一个节点
            $l3Cur = $sumNode;
            $l1 = $l1->next ?? null;
            $l2 = $l2->next ?? null;
        }
        return $l3->next;
    }
}

$s = new Solution();
$n1 = new ListNode(2);
$n1->next = new ListNode(4);
$n1->next->next = new ListNode(3);

$n2 = new ListNode(5);
$n2->next = new ListNode(6);
$n2->next->next = new ListNode(4);
var_dump($s->addTwoNumbers($n1, $n2));   // 708