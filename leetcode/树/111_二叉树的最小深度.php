<?php

// 给定一个二叉树，找出其最小深度。
//
//最小深度是从根节点到最近叶子节点的最短路径上的节点数量。
//
//说明: 叶子节点是指没有子节点的节点。
//
//示例:
//
//给定二叉树 [3,9,20,null,null,15,7],
//
//    3
//   / \
//  9  20
//    /  \
//   15   7
//返回它的最小深度  2.
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/minimum-depth-of-binary-tree
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。
//
// 思路
// 使用从上往下的遍历, 使用队列来实现
// 设置最小值, 当一个分支高于这个值的时候, 就放弃往下查深度

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
     * 广度遍历(队列实现)
     * 时间复杂度: O(n)
     * 空间复杂度: 最差O(n), 最好O(logN)
     * @param TreeNode $root
     * @return Integer
     */
    function minDepth1($root)
    {
        if ($root === null) return 0;
        $min = PHP_INT_MAX;
        $queue = [[$root, 1]];
        while (!empty($queue)) {
            [$tree, $deep] = array_shift($queue);
            if ($deep > $min) {
                continue;
            }
            if (empty($tree->left) && empty($tree->right)) {
                $min = min($min, $deep);
            }
            if (!empty($tree->left)) {
                $queue[] = [$tree->left, $deep + 1];
            }
            if (!empty($tree->right)) {
                $queue[] = [$tree->right, $deep + 1];
            }
        }
        return $min;
    }
}

$s = new Solution();
$tree = new TreeNode(3);
$tree->left = new TreeNode(9);
$tree->right = new TreeNode(20);
$tree->right->left = new TreeNode(15);
$tree->right->right = new TreeNode(7);

var_dump($s->minDepth($tree)); // 2

$t2 = new TreeNode(1);
$t2->left = new TreeNode(2);
$t2->right = new TreeNode(3);
$t2->left->left = new TreeNode(4);
$t2->left->right = new TreeNode(5);

var_dump($s->minDepth($t2)); // 2