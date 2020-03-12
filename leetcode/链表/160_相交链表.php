<?php

// 编写一个程序，找到两个单链表相交的起始节点。
//
//如下面的两个链表：
//
//
//
//在节点 c1 开始相交。
//
// 
//
//示例 1：
//
//
//
//输入：intersectVal = 8, listA = [4,1,8,4,5], listB = [5,0,1,8,4,5], skipA = 2, skipB = 3
//输出：Reference of the node with value = 8
//输入解释：相交节点的值为 8 （注意，如果两个列表相交则不能为 0）。从各自的表头开始算起，链表 A 为 [4,1,8,4,5]，链表 B 为 [5,0,1,8,4,5]。在 A 中，相交节点前有 2 个节点；在 B 中，相交节点前有 3 个节点。
// 
//
//示例 2：
//
//
//
//输入：intersectVal = 2, listA = [0,9,1,2,4], listB = [3,2,4], skipA = 3, skipB = 1
//输出：Reference of the node with value = 2
//输入解释：相交节点的值为 2 （注意，如果两个列表相交则不能为 0）。从各自的表头开始算起，链表 A 为 [0,9,1,2,4]，链表 B 为 [3,2,4]。在 A 中，相交节点前有 3 个节点；在 B 中，相交节点前有 1 个节点。
// 
//
//示例 3：
//
//
//
//输入：intersectVal = 0, listA = [2,6,4], listB = [1,5], skipA = 3, skipB = 2
//输出：null
//输入解释：从各自的表头开始算起，链表 A 为 [2,6,4]，链表 B 为 [1,5]。由于这两个链表不相交，所以 intersectVal 必须为 0，而 skipA 和 skipB 可以是任意值。
//解释：这两个链表不相交，因此返回 null。
// 
//
//注意：
//
//如果两个链表没有交点，返回 null.
//在返回结果后，两个链表仍须保持原有的结构。
//可假定整个链表结构中没有循环。
//程序尽量满足 O(n) 时间复杂度，且仅用 O(1) 内存。
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/intersection-of-two-linked-lists
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
     * A+B = B+A
     * 两层循环, 走的步数都是 A + B 步
     * 当 len(A) == len(B) 且有交点时, 在第一轮就会遇到  cA === cB
     * 当 len(A) != len(B) 有交点时, 在第二轮会遇到 cA === cB
     * 当 len(A) == len(B) 无交点时, 第一轮会遇到  cA === cB === null
     * 当 len(A) !== len(B) 无交点时, 第二轮会遇到 cA === cB === null
     * 时间复杂度: O(m + n)
     * 空间复杂度: O(1)
     * @param ListNode $headA
     * @param ListNode $headB
     * @return ListNode
     */
    function getIntersectionNode($headA, $headB)
    {
        if ($headA === null || $headB === null) {
            return null;
        }
        $cA = $headA;
        $cB = $headB;
        while ($cA !== $cB) {
            $cA = $cA === null ? $headB : $cA->next;
            $cB = $cB === null ? $headA : $cB->next;
        }
        return $cA;
    }

    /**
     * 两层循环
     * 时间复杂度: O(mn)
     * 空间复杂度: O(1)
     * @param ListNode $headA
     * @param ListNode $headB
     * @return ListNode
     */
    function getIntersectionNode1($headA, $headB)
    {
        $cA = $headA;
        while ($cA !== null) {
            $cB = $headB;
            while ($cB !== null) {
                if ($cB === $cA) {
                    return $cB;
                }
                $cB = $cB->next;
            }
            $cA = $cA->next;
        }
        return null;
    }
}

$s = new Solution();

$l1 = new ListNode(4);
$l1->next = new ListNode(1);
$l1->next->next = new ListNode(8);
$l1->next->next->next = new ListNode(4);
$l1->next->next->next->next = new ListNode(5);
$l2 = new ListNode(5);
$l2->next = new ListNode(0);
$l2->next->next = new ListNode(1);
$l2->next->next->next = $l1->next->next;

var_dump($s->getIntersectionNode($l1, $l2)); // 8->4->5