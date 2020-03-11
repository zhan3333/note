<?php

// 给定一个链表，判断链表中是否有环。
//
//为了表示给定链表中的环，我们使用整数 pos 来表示链表尾连接到链表中的位置（索引从 0 开始）。 如果 pos 是 -1，则在该链表中没有环。
//
// 
//
//示例 1：
//
//输入：head = [3,2,0,-4], pos = 1
//输出：true
//解释：链表中有一个环，其尾部连接到第二个节点。
//
//
//示例 2：
//
//输入：head = [1,2], pos = 0
//输出：true
//解释：链表中有一个环，其尾部连接到第一个节点。
//
//
//示例 3：
//
//输入：head = [1], pos = -1
//输出：false
//解释：链表中没有环。
//
//
// 
//
//进阶：
//
//你能用 O(1)（即，常量）内存解决此问题吗？
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/linked-list-cycle
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。


class ListNode
{
    public $next = null;
    public $val = null;

    public function __construct($val)
    {
        $this->val = $val;
    }
}

class Solution
{
    /**
     * 快慢指针法
     * 时间复杂度: O(n)
     * 空间复杂度: O(1)
     * @param ListNode $list
     * @return bool
     */
    function hasCycle(ListNode $list)
    {
        if (empty($list->next)) {
            return false;
        }
        $fast = $list;
        $slow = $list;
        while ($fast !== null) {
            if (!empty($fast->next->next)) {
                $fast = $fast->next->next;
            } else {
                $fast = null;
            }
            if ($fast === $slow) {
                return true;
            }
            $slow = $slow->next;
        }
        return false;
    }
}

$s = new Solution();
$l1 = new ListNode(3);
$l1->next = new ListNode(2);
$l1->next->next = new ListNode(0);
$l1->next->next->next = new ListNode(-1);
$l1->next->next->next->next = $l1->next;

var_dump($s->hasCycle($l1)); // true

$l2 = new ListNode(1);
$l2->next = new ListNode(2);
$l2->next->next = $l2;
var_dump($s->hasCycle($l2)); // true

$l3 = new ListNode(1);
var_dump($s->hasCycle($l3)); // false

$l4 = new ListNode(1);
$l4->next = new ListNode(2);
var_dump($s->hasCycle($l4)); // false