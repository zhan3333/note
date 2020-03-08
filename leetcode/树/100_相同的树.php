<?php

// 给定两个二叉树，编写一个函数来检验它们是否相同。
//
//如果两个树在结构上相同，并且节点具有相同的值，则认为它们是相同的。
//
//示例 1:
//
//输入:       1         1
//          / \       / \
//         2   3     2   3
//
//        [1,2,3],   [1,2,3]
//
//输出: true
//示例 2:
//
//输入:      1          1
//          /           \
//         2             2
//
//        [1,2],     [1,null,2]
//
//输出: false
//示例 3:
//
//输入:       1         1
//          / \       / \
//         2   1     1   2
//
//        [1,2,1],   [1,1,2]
//
//输出: false
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/same-tree
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。
//
//


class TreeNode
{
    public $val = null;
    public $left = null;
    public $right = null;

    function __construct($value)
    {
        $this->val = $value;
    }
}

/**
 * Definition for a binary tree node.
 * class TreeNode {
 *     public $val = null;
 *     public $left = null;
 *     public $right = null;
 *     function __construct($value) { $this->val = $value; }
 * }
 */
class Solution
{

    /**
     * 先序遍历双栈判断是否相等
     * @param TreeNode $p
     * @param TreeNode $q
     * @return bool
     */
    function isSameTree($p, $q)
    {
        $pStack = [$p];
        $qStack = [$q];
        while (!empty($pStack) || !empty($qStack)) {
            $pNode = array_pop($pStack);
            $qNode = array_pop($qStack);
            if ($pNode === null && $qNode === null) {
                continue;
            }
            if ($pNode === null || $qNode === null || ($pNode->val !== $qNode->val)) {
                return false;
            }
            // 注意null节点也需要入栈, 否则无法区分 1. 左树 空右树 2. 空左树 右树 是否相等
            $pStack[] = $pNode->right;
            $pStack[] = $pNode->left;
            $qStack[] = $qNode->right;
            $qStack[] = $qNode->left;
        }
        return true;
    }

    /**
     * 最直观的递归算法
     * 截止条件: p === null && q === null
     * 递归公式: (p.left, q.left) (p.right, q.right)
     * @param TreeNode $p
     * @param TreeNode $q
     * @return Boolean
     */
    function isSameTree1($p, $q)
    {
        if ($p === null && $q === null) {
            return true;
        }
        if ($p !== null && $q !== null && $p->val === $q->val) {
            return $this->isSameTree($p->left, $q->left) && $this->isSameTree($p->right, $q->right);
        } else {
            return false;
        }
    }
}

$s = new Solution();

$p = new TreeNode(1);
$p->left = new TreeNode(2);
$p->right = new TreeNode(3);

$q = new TreeNode(1);
$q->left = new TreeNode(2);
$q->right = new TreeNode(3);


var_dump($s->isSameTree($p, $q));  // true