<?php

// 在 O(n log n) 时间复杂度和常数级空间复杂度下，对链表进行排序。
//
//示例 1:
//
//输入: 4->2->1->3
//输出: 1->2->3->4
//示例 2:
//
//输入: -1->5->3->4->0
//输出: -1->0->3->4->5
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/sort-list
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

class Solution
{

    /**
     * 归并链表版本
     * @param ListNode $head
     * @return ListNode
     */
    function sortList($head)
    {
        $myHead = new ListNode(-1);
        $myHead->next = $head;
        $t = $head;
        $len = 0;
        while ($t) {
            $len++;
            $t = $t->next;
        }
        for ($i = 1; $i < $len; $i <<= 1) {
            $cur = $myHead->next;
            $tail = $myHead;
            while ($cur) {
                $left = $cur;
                $right = $this->cut($left, $i);
                $cur = $this->cut($right, $i);
                $tail->next = $this->merge($left, $right);
                while ($tail->next) {
                    $tail = $tail->next;
                }
            }
        }
        return $myHead->next;
    }

    function cut($node, $size)
    {
        $p = $node;
        while (--$size && $p) {
            $p = $p->next;
        }
        if (!$p) {
            return null;
        }
        $next = $p->next;
        $p->next = null;
        return $next;
    }

    /**
     * 合并两个有序链表为一个有序链表
     * @param $l1
     * @param $l2
     * @return ListNode|null
     */
    function merge($l1, $l2)
    {
        $l = new ListNode(0);
        $p = $l;
        while ($l1 && $l2) {
            if ($l1->val < $l2->val) {
                $p->next = $l1;
                $p = $l1;
                $l1 = $l1->next;
            } else {
                $p->next = $l2;
                $p = $l2;
                $l2 = $l2->next;
            }
        }
        $p->next = $l1 ?? $l2;
        return $l->next;
    }
}