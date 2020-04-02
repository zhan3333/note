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
// 进阶：
//你能否用 O(n) 时间复杂度和 O(1) 空间复杂度解决此题？

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

    function isPalindrome($head)
    {
        if ($head === null || $head->next === null) {
            return true;
        }
        $fast = $head;
        $slow = $head;
        while ($fast !== null && $fast->next !== null && $fast->next->next !== null) {
            $fast = $fast->next->next;
            $slow = $slow->next;
        }
        $left = $head;
        $right = $slow->next;
        $slow->next = null;

        $prev = null;
        while ($right !== null) {
            $next = $right->next;
            $right->next = $prev;
            $prev = $right;
            $right = $next;
        }
        $right = $prev;
        while ($left !== null && $right !== null) {
            if ($left->val !== $right->val) {
                return false;
            }
            $left = $left->next;
            $right = $right->next;
        }
        return $left === null || $left->next === null;
    }

    /**
     * 时间复杂度 O(n)
     * 空间复杂度 O(n)
     * @param ListNode $head
     * @return Boolean
     */
    function isPalindrome1($head)
    {
        $stack = [];
        $cur = $head;
        while ($cur !== null) {
            if (empty($stack)) {
                $stack[] = $cur->val;
            } else {
                $pop = array_pop($stack);
                if ($pop !== $cur->val) {
                    $stack[] = $pop;
                    $stack[] = $cur->val;
                }
            }
            $cur = $cur->next;
        }
        return empty($stack);
    }
}

$s = new Solution();

//var_dump($s->isPalindrome(null)); // true

$l = new ListNode(0);
$l->next = new ListNode(0);

//var_dump($s->isPalindrome($l)); // true

$l2 = new ListNode(1);
$l2->next = new ListNode(2);
$l2->next->next = new ListNode(2);
$l2->next->next->next = new ListNode(1);

var_dump($s->isPalindrome($l2)); // true
