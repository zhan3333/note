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

class Solution
{

    /**
     * 非递归, while 解决
     * 时间复杂度: O(n)
     * 空间复杂度: O(1) 只使用了 prev 一个变量
     * @param $head
     * @return null
     */
    function reverseList($head)
    {
        $prev = null;
        $node = $head;
        while ($node !== null) {
            $next = $node->next;
            $node->next = $prev;
            $prev = $node;
            $node = $next;
        }
        return $prev;
    }

    /**
     * 递归解法
     * 时间复杂度: O(n)
     * 空间复杂度: O(1) 尾递归, 栈空间很小
     * @param ListNode $head
     * @return ListNode
     */
    function reverseList1($head)
    {
        return $this->reverseNode(null, $head);
    }

    function reverseNode($prev, $node)
    {
        if ($node === null) {
            return $prev;
        }
        $next = $node->next;
        $node->next = $prev;
        return $this->reverseNode($node, $next);
    }
}