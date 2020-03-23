<?php

// 给定一个带有头结点 head 的非空单链表，返回链表的中间结点。
//
//如果有两个中间结点，则返回第二个中间结点。
//
// 
//
//示例 1：
//
//输入：[1,2,3,4,5]
//输出：此列表中的结点 3 (序列化形式：[3,4,5])
//返回的结点值为 3 。 (测评系统对该结点序列化表述是 [3,4,5])。
//注意，我们返回了一个 ListNode 类型的对象 ans，这样：
//ans.val = 3, ans.next.val = 4, ans.next.next.val = 5, 以及 ans.next.next.next = NULL.
//示例 2：
//
//输入：[1,2,3,4,5,6]
//输出：此列表中的结点 4 (序列化形式：[4,5,6])
//由于该列表有两个中间结点，值分别为 3 和 4，我们返回第二个结点。
// 
//
//提示：
//
//给定链表的结点数介于 1 和 100 之间。
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/middle-of-the-linked-list
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
     * 快慢指针
     * 时间复杂度: O(n) 只移动 n/2 次
     * 空间复杂度: O(1)
     * @param ListNode $head
     * @return ListNode
     */
    function middleNode($head)
    {
        if ($head->next === null) {
            return $head;
        }
        $fast = $head;
        $slow = $head;
        while ($fast->next !== null && $fast->next->next !== null) {
            $fast = $fast->next->next;
            $slow = $slow->next;
        }
        if ($fast->next !== null) {
            return $slow->next;
        }
        return $slow;
    }
}

$l = new ListNode(1);
$l->next = new ListNode(2);
$l->next->next = new ListNode(3);
$l->next->next->next = new ListNode(4);
$l->next->next->next->next = new ListNode(5);

$s = new Solution();
var_dump($s->middleNode($l)); // 3, 4, 5

$l2 = new ListNode(1);
$l2->next = new ListNode(2);
var_dump($s->middleNode($l2)); // 2

$l3 = new ListNode(1);
$l3->next = new ListNode(2);
$l3->next->next = new ListNode(3);
var_dump($s->middleNode($l3)); // 2, 3