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

    /**
     * @param ListNode $l1
     * @param ListNode $l2
     * @return ListNode
     */
    function mergeTwoLists($l1, $l2)
    {
        $l3 = new ListNode(0);
        $cur = $l3;
        while ($l1 !== null || $l2 !== null) {
            if ($l1 === null) {
                $cur->next = $l2;
                $l2 = $l2->next;
            } else if ($l2 === null) {
                $cur->next = $l1;
                $l1 = $l1->next;
            } else {
                if ($l1->val < $l2->val) {
                    $cur->next = $l1;
                    $l1 = $l1->next;
                } else {
                    $cur->next = $l2;
                    $l2 = $l2->next;
                }
            }
            $cur = $cur->next;
        }
        return $l3->next;
    }
}

$s = new Solution();

$l1 = new ListNode(1);
$l1->next = new ListNode(2);
$l1->next->next = new ListNode(4);

$l2 = new ListNode(1);
$l2->next = new ListNode(3);
$l2->next->next = new ListNode(4);

var_dump($s->mergeTwoLists($l1, $l2)); // 1, 1, 2, 3, 4, 4