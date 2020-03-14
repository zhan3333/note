<?php

// 合并 k 个排序链表，返回合并后的排序链表。请分析和描述算法的复杂度。
//
//示例:
//
//输入:
//[
//  1->4->5,
//  1->3->4,
//  2->6
//]
//输出: 1->1->2->3->4->4->5->6
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/merge-k-sorted-lists
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。


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
     * 采用两两合并的方式, 使链表数量指数下降, 时间复杂度为 O(logK)
     * 时间复杂度: O(nLogK) k为链表长度, n为总节点数量
     * 空间复杂度: O(1)
     * @param ListNode[] $lists
     * @return ListNode
     */
    function mergeKLists($lists)
    {
        while (count($lists) > 1) {
            $l1 = array_shift($lists);
            $l2 = array_shift($lists);
            $lists[] = $this->mergeTwo($l1, $l2);
        }
        return $lists[0];
    }

    /**
     * @param ListNode $l1
     * @param ListNode $l2
     * @return ListNode
     */
    function mergeTwo($l1, $l2)
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
}

$s = new Solution();

$l1 = new ListNode(1);
$l1->next = new ListNode(4);
$l1->next->next = new ListNode(5);

$l2 = new ListNode(1);
$l2->next = new ListNode(3);
$l2->next->next = new ListNode(4);

$l3 = new ListNode(2);
$l3->next = new ListNode(6);

var_dump($s->mergeKLists([$l1, $l2, $l3])); // 1->1->2->3->4->4->5->6