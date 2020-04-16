<?php

// 请判断一个链表是否为回文链表。
//
//示例 1:
//
//输入: 1->2
//输出: false
//示例 2:
//
//输入: 1->2->2->1
//输出: true
//进阶：
//你能否用 O(n) 时间复杂度和 O(1) 空间复杂度解决此题？
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/palindrome-linked-list
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

class Solution
{
    /**
     * 反转前一半链表, 然后与后一半比较
     * @param $head
     * @return bool
     */
    function isPalindrome2($head)
    {
        if ($head === null || $head->next === null) {
            return true;
        }
        $fast = $head;
        $slow = $head;
        while ($fast->next !== null && $fast->next->next !== null) {
            $slow = $slow->next;
            $fast = $fast->next;
        }
        $l1 = $head;
        $l2 = $slow->next;
        $slow->next = null; // 断开 l1, l2
        // 反转 l2
        $prev = null;
        while ($l2 !== null) {
            $next = $l2->next;
            $l2->next = $prev;
            $prev = $l2;
            $l2 = $next;
        }
        $l2 = $prev;
        // 比较 l1, l2 是否相等
        while ($l1 !== null && $l2 !== null) {
            if ($l1->val !== $l2->val) {
                return false;
            }
            $l1 = $l1->next;
            $l2 = $l2->next;
        }
        return true;
    }

    /**
     * 反转链表然后比较
     * @param ListNode $head
     * @return Boolean
     */
    function isPalindrome1($head)
    {
        if ($head === null || $head->next === null) {
            return true;
        }
        $arr = [];
        $cur = $head;
        while ($cur !== null) {
            $arr[] = $cur->val;
            $cur = $cur->next;
        }
        return array_reverse($arr) === $arr;
    }
}