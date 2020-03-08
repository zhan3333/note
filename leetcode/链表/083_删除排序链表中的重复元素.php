<?php

// 给定一个排序链表，删除所有重复的元素，使得每个元素只出现一次。
//
//示例 1:
//
//输入: 1->1->2
//输出: 1->2
//示例 2:
//
//输入: 1->1->2->3->3
//输出: 1->2->3
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/remove-duplicates-from-sorted-list
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。
//
// 思路
// 遍历链表, 将next指针指到下一个不重复的节点上

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
     * 单指针解法
     * 时间复杂度: O(n)
     * 空间复杂度: O(1)
     *
     * @param $head
     * @return mixed
     */
    function deleteDuplicates($head)
    {
        $cur = $head;
        while ($cur !== null && $cur->next !== null) {
            if ($cur->val === $cur->next->val) {
                $cur->next = $cur->next->next;
            } else {
                // 连续重复数字, 需要在不相等的情况下才移动到下一位
                $cur = $cur->next;
            }
        }
        return $head;
    }

    /**
     * 双指针解法
     * 时间复杂度: O(n)
     * 空间复杂度: O(1)
     *
     * @param ListNode $head
     * @return ListNode
     */
    function deleteDuplicates1($head)
    {
        if ($head === null || $head->next === null) return $head;
        $fast = $head->next;
        $slow = $head;
        while ($fast !== null) {
            if ($fast->val !== $slow->val) {
                $slow->next = $fast;
                $slow = $slow->next;
            }
            $fast = $fast->next;
            $slow->next = null;
        }
        return $head;
    }
}

$s = new Solution();

$list = new ListNode(1);
$list->next = new ListNode(1);
$list->next->next = new ListNode(2);
var_dump($s->deleteDuplicates($list));  // 1->2