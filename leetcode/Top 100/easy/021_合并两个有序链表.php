<?php

// 将两个升序链表合并为一个新的升序链表并返回。新链表是通过拼接给定的两个链表的所有节点组成的。 
//
//示例：
//
//输入：1->2->4, 1->3->4
//输出：1->1->2->3->4->4
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/merge-two-sorted-lists
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

class Solution
{

    /**
     * 拆开写更好看
     * 时间复杂度: O(m + n)
     * 空间复杂度: O(1) 原地合并
     * @param ListNode $l1
     * @param ListNode $l2
     * @return ListNode
     */
    function mergeTwoLists($l1, $l2)
    {
        $new = new ListNode(-1);
        $cur = $new;
        while ($l1 !== null && $l2 !== null) {
            if ($l1->val < $l2->val) {
                $cur->next = $l1;
                $l1 = $l1->next;
            } else {
                $cur->next = $l2;
                $l2 = $l2->next;
            }
            $cur = $cur->next;
        }
        if ($l1 !== null) {
            $cur->next = $l1;
        }
        if ($l2 !== null) {
            $cur->next = $l2;
        }
        return $new->next;
    }
}