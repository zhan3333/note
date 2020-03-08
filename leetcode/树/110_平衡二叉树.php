<?php

// 给定一个二叉树，判断它是否是高度平衡的二叉树。
//
//本题中，一棵高度平衡二叉树定义为：
//
//一个二叉树每个节点 的左右两个子树的高度差的绝对值不超过1。
//
//示例 1:
//
//给定二叉树 [3,9,20,null,null,15,7]
//
//    3
//   / \
//  9  20
//    /  \
//   15   7
//返回 true 。
//
//示例 2:
//
//给定二叉树 [1,2,2,3,3,null,null,4,4]
//
//       1
//      / \
//     2   2
//    / \
//   3   3
//  / \
// 4   4
//返回 false 。
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/balanced-binary-tree
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

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
     * 广度优先遍历 BFS
     * 时间复杂度: O(n)
     * 空间复杂度: 最差线性树O(n), 最优平衡二叉树O(logN)
     * @param TreeNode $root
     * @return Boolean
     */
    function isBalanced($root)
    {
        if ($root === null) return true;
        $min = 0; // 最小叶子层数
        $max = 1; // 最大叶子层数
        $queue = [[$root, 1]];
        while (!empty($queue)) {
            [$tree, $deep] = array_shift($queue);
            if ($tree !== null) {
                if ($tree->left === null && $tree->right === null) {
                    // 叶子节点
                    $min = min($min, $deep);
                }
                $max = max($max, $deep);
                if ($max - $min > 2) {
                    return false;
                }
                $queue[] = [$tree->left, $deep + 1];
                $queue[] = [$tree->right, $deep + 1];
            }
        }
        return true;
    }
}

$root = new TreeNode(3);
$root->left = new TreeNode(9);
$root->right = new TreeNode(20);
$root->right->left = new TreeNode(15);
$root->right->right = new TreeNode(7);

$s = new Solution();
var_dump($s->isBalanced($root)); // true

$t2 = new TreeNode(1);
$t2->left = new TreeNode(2);
$t2->right = new TreeNode(2);
$t2->left->left = new TreeNode(3);
$t2->left->right = new TreeNode(3);
$t2->left->left->left = new TreeNode(4);
$t2->left->left->right = new TreeNode(4);

var_dump($s->isBalanced($t2)); // false
