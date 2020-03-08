<?php

// 给定一个二叉树，返回其节点值自底向上的层次遍历。 （即按从叶子节点所在层到根节点所在的层，逐层从左向右遍历）
//
//例如：
//给定二叉树 [3,9,20,null,null,15,7],
//
//    3
//   / \
//  9  20
//    /  \
//   15   7
//返回其自底向上的层次遍历为：
//
//[
//  [15,7],
//  [9,20],
//  [3]
//]
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/binary-tree-level-order-traversal-ii
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。
//
// 思考
// 这题像层序遍历过程中储存结果

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
     * 队列做法 (层次遍历, BFS)
     * 时间复杂度: O(n)
     * 空间复杂度: 最差 O(n) (线性二叉树), 最优 O(logn) (平衡二叉树)
     * @param TreeNode $root
     * @return Integer[][]
     */
    function levelOrderBottom($root)
    {
        $queue = [[$root, 0]];
        $res = [];
        while (!empty($queue)) {
            [$tree, $deep] = array_shift($queue);
            if ($tree !== null) {
                $res[$deep][] = $tree->val;
                $queue[] = [$tree->left, $deep + 1];
                $queue[] = [$tree->right, $deep + 1];
            }
        }
        return $res;
    }
}

$t = new TreeNode(3);
$t->left = new TreeNode(9);
$t->right = new TreeNode(20);
$t->right->left = new TreeNode(15);
$t->right->right = new TreeNode(7);

$s = new Solution();

//[
//  [15,7],
//  [9,20],
//  [3]
//]
var_dump($s->levelOrderBottom($t));