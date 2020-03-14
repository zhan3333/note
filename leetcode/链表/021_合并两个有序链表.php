<?php

// 将两个有序链表合并为一个新的有序链表并返回。新链表是通过拼接给定的两个链表的所有节点组成的。 
//
//示例：
//
//输入：1->2->4, 1->3->4
//输出：1->1->2->3->4->4
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/merge-two-sorted-lists
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

// 思考
// 遍历两个链表, 比较值插入新链表中

class ListNode
{
    public $val = 0;
    public $next = null;

    public function __construct($val)
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
     * 使用O(1) 空间复杂度来实现
     * @param ListNode $l1
     * @param ListNode $l2
     * @return null
     */
    function mergeTwoLists($l1, $l2)
    {
        $l3 = new ListNode(0);
        $cur = $l3;
        while ($l1 !== null || $l2 !== null) {
            if ($l1 === null) {
                $cur->next = $l2;
                $l2 = $l2->next;
            } elseif ($l2 === null) {
                $cur->next = $l1;
                $l1 = $l1->next;
            } else {
                if ($l1->val > $l2->val) {
                    $cur->next = $l2;
                    $l2 = $l2->next;
                } else {
                    $cur->next = $l1;
                    $l1 = $l1->next;
                }
            }
            $cur = $cur->next;
        }
        return $l3->next;
    }


    /**
     * 空间复杂度: O(m+n)
     * 时间复杂度 O(m+n)
     * @param ListNode $l1
     * @param ListNode $l2
     * @return ListNode
     */
    function mergeTwoLists1($l1, $l2)
    {
        $l3 = new ListNode(0);
        $cur = $l3;
        while ($l1 !== null || $l2 !== null) {
            if ($l1 === null) {
                $val = $l2->val;
                $l2 = $l2->next;
            } elseif ($l2 === null) {
                $val = $l1->val;
                $l1 = $l1->next;
            } else {
                if ($l1->val <= $l2->val) {
                    $val = $l1->val;
                    $l1 = $l1->next;
                } else {
                    $val = $l2->val;
                    $l2 = $l2->next;
                }
            }
            $cur->next = new ListNode($val);
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
var_dump($s->mergeTwoLists($l1, $l2)); // 1->1->2->3->4->4