<?php

// 反转一个单链表。
//
//示例:
//
//输入: 1->2->3->4->5->NULL
//输出: 5->4->3->2->1->NULL
//进阶:
//你可以迭代或递归地反转链表。你能否用两种方法解决这道题？
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/reverse-linked-list
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
     * 迭代实现
     * 时间复杂度: O(n) 一次迭代
     * 空间复杂度: O(1)
     * @param $head
     * @return mixed
     */
    function reverseList($head)
    {
        $prev = null;
        $cur = $head;
        while ($cur !== null) {
            $next = $cur->next;
            $cur->next = $prev;
            $prev = $cur;
            $cur = $next;
        }
        return $prev;
    }

    /**
     * 递归实现, 每次交换链表头部的方向
     * 时间复杂度: O(n)
     * 空间复杂度: O(n) 递归使用的
     * @param ListNode $head
     * @return mixed
     */
    function reverseList2($head)
    {
        if ($head === null || $head->next === null) {
            return $head;
        }
        $p = $this->reverseList2($head->next);
        // 反向链表头部
        $head->next->next = $head;
        $head->next = null;
        return $p;
    }


    /**
     * 栈实现
     * 时间复杂度: O(n)
     * 空间复杂度: O(n) 使用了栈储存对象
     * @param ListNode $head
     * @return ListNode
     */
    function reverseList1($head)
    {
        $stack = [];
        $cur = $head;
        while ($cur !== null) {
            $stack[] = $cur;
            $cur = $cur->next;
        }
        $newList = new ListNode(0);
        $newListCur = $newList;
        while (!empty($stack)) {
            $newListCur->next = array_pop($stack);
            $newListCur->next->next = null;
            $newListCur = $newListCur->next;
        }
        return $newList->next;
    }
}

$l = new ListNode(1);
$l->next = new ListNode(2);
$l->next->next = new ListNode(3);
$l->next->next->next = new ListNode(4);
$l->next->next->next->next = new ListNode(5);

$s = new Solution();
var_dump($s->reverseList($l)); // 5->4->3->2->1