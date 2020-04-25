<?php

class Solution
{

    /**
     * 时间复杂度: O(n) 遍历了两遍链表, 一次计数, 一次找断开节点
     * 空间复杂度: O(1) 没有使用额外空间
     * @param ListNode $head
     * @param Integer $k
     * @return ListNode
     */
    function rotateRight($head, $k)
    {
        // 链表空或者k=0没有必要继续
        if ($k === 0 || $head === null) {
            return $head;
        }
        $count = 0;
        $t = $head;
        while ($t !== null) {
            $count++;
            $t = $t->next;
        }
        // 优化: 减少遍历链表次数, 从 $k / len($head) 次优化到了 1 次
        $k %= $count;
        $fast = $head;
        $slow = $head;
        // 先走k步
        for ($i = 0; $i < $k; $i++) {
            $fast = $fast->next;
        }
        while ($fast->next !== null) {
            $fast = $fast->next;
            $slow = $slow->next;
        }
        if ($fast === $slow) {
            return $head;
        }
        // 断开节点前后, 并将后边节点移到前边
        $l1 = $head;
        $l2 = $slow->next;
        $slow->next = null;
        $fast->next = $l1;
        return $l2;
    }
}