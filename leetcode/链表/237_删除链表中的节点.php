<?php

// 请编写一个函数，使其可以删除某个链表中给定的（非末尾）节点，你将只被给定要求被删除的节点。
//
//现有一个链表 -- head = [4,5,1,9]，它可以表示为:
//
//
//
// 
//
//示例 1:
//
//输入: head = [4,5,1,9], node = 5
//输出: [4,1,9]
//解释: 给定你链表中值为 5 的第二个节点，那么在调用了你的函数之后，该链表应变为 4 -> 1 -> 9.
//示例 2:
//
//输入: head = [4,5,1,9], node = 1
//输出: [4,5,9]
//解释: 给定你链表中值为 1 的第三个节点，那么在调用了你的函数之后，该链表应变为 4 -> 5 -> 9.
// 
//
//说明:
//
//链表至少包含两个节点。
//链表中所有节点的值都是唯一的。
//给定的节点为非末尾节点并且一定是链表中的一个有效节点。
//不要从你的函数中返回任何结果。
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/delete-node-in-a-linked-list
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。


class ListNode
{
    public $val = null;
    /** @var ListNode */
    public $next = null;

    public function __construct($val)
    {
        $this->val = $val;
    }
}

class Solution
{
    /**
     *
     * @param ListNode $root
     */
    function deleteNode($root, $node)
    {
        $cur = $root;
        $prev = null;
        // 非末尾节点
        while ($cur->next !== null) {
            $next = $cur->next;
            if ($cur->val === $node) {
                // 找到节点, 删除节点
                $prev->next = $next;
                $cur->next = null;
                return;
            }
            $prev = $cur;
            $cur = $cur->next;
        }
    }
}

$s = new Solution();

$l = new ListNode(4);
$l->next = new ListNode(5);
$l->next->next = new ListNode(1);
$l->next->next->next = new ListNode(9);

$s->deleteNode($l, 5);

var_dump($l); // 4, 1, 9

$s->deleteNode($l, 1);

var_dump($l); // 4, 9