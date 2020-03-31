<?php

// 给定一个链表，删除链表的倒数第 n 个节点，并且返回链表的头结点。
//
//示例：
//
//给定一个链表: 1->2->3->4->5, 和 n = 2.
//
//当删除了倒数第二个节点后，链表变为 1->2->3->5.
//说明：
//
//给定的 n 保证是有效的。
//
//进阶：
//
//你能尝试使用一趟扫描实现吗？
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/remove-nth-node-from-end-of-list
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
     * @param ListNode $head
     * @param Integer $n
     * @return ListNode
     */
    function removeNthFromEnd($head, $n)
    {
        if ($n < 1 || $head === null) {
            return $head;
        }
        $fast = $head;
        $slow = $head;
        $i = 1;
        while ($i < $n) {
            $fast = $fast->next;
            $i++;
        }
        $prev = null;
        while ($fast !== null) {
            if ($fast->next === null) {
                if ($prev === null) {
                    // 删除第一个元素
                    $head = $head->next;
                } else {
                    $prev->next = $slow->next;
                }
                return $head;
            }
            $fast = $fast->next;
            $prev = $slow;
            $slow = $slow->next;
        }
    }
}

$l = new ListNode(1);
$l->next = new ListNode(2);
$l->next->next = new ListNode(3);
$l->next->next->next = new ListNode(4);
$l->next->next->next->next = new ListNode(5);

$s = new Solution();
var_dump($s->removeNthFromEnd($l, 2)); // 1, 2, 3, 5


$l = new ListNode(1);
var_dump($s->removeNthFromEnd($l, 1)); // []

$l = new ListNode(1);
$l->next = new ListNode(2);
var_dump($s->removeNthFromEnd($l, 2)); // [2]