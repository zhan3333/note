<?php

// 给定一个二叉树和一个目标和，判断该树中是否存在根节点到叶子节点的路径，这条路径上所有节点值相加等于目标和。
//
//说明: 叶子节点是指没有子节点的节点。
//
//示例: 
//给定如下二叉树，以及目标和 sum = 22，
//
//              5
//             / \
//            4   8
//           /   / \
//          11  13  4
//         /  \      \
//        7    2      1
//返回 true, 因为存在目标和为 22 的根节点到叶子节点的路径 5->4->11->2。
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/path-sum
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。
//
// 思考
// 显然使用深度优先遍历, 用栈来实现
// 当计数和大于需要的值时, 直接放弃该枝干

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
     * 深度优先搜索
     * 时间复杂度: O(n)
     * 空间复杂度: 最好O(logN), 最差O(n)
     * @param TreeNode $root
     * @param Integer $sum
     * @return Boolean
     */
    function hasPathSum($root, $sum)
    {
        if ($root === null) {
            return false;
        }
        $stack = [[$root, $root->val]];
        while (!empty($stack)) {
            [$tree, $s] = array_pop($stack);
            if (empty($tree->left) && empty($tree->right) && $s === $sum) {
                return true;
            }
            if ($tree->right !== null) {
                $stack[] = [$tree->right, $s + $tree->right->val];
            }
            if ($tree->left !== null) {
                $stack[] = [$tree->left, $s + $tree->left->val];
            }
        }
        return false;
    }
}

$s = new Solution();

$t = new TreeNode(5);
$t->left = new TreeNode(4);
$t->left->left = new TreeNode(11);
$t->left->left->left = new TreeNode(7);
$t->left->left->right = new TreeNode(2);
$t->right = new TreeNode(8);
$t->right->left = new TreeNode(13);
$t->right->right = new TreeNode(4);
$t->right->right->right = new TreeNode(1);

var_dump($s->hasPathSum($t, 22));  // true
var_dump($s->hasPathSum($t, 1));  // false

$t2 = new TreeNode(-2);
$t2->right = new TreeNode(-3);

var_dump($s->hasPathSum($t2, -5)); // true