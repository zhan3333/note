<?php

// 给定一个二叉树，返回所有从根节点到叶子节点的路径。
//
//说明: 叶子节点是指没有子节点的节点。
//
//示例:
//
//输入:
//
//   1
// /   \
//2     3
// \
//  5
//
//输出: ["1->2->5", "1->3"]
//
//解释: 所有根节点到叶子节点的路径为: 1->2->5, 1->3
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/binary-tree-paths
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

class Solution
{

    /**
     * 优化
     * @param $root
     * @return array
     */
    function binaryTreePaths($root)
    {
        if ($root === null) {
            return [];
        }
        $stack = [[$root, (string)$root->val]];
        $ans = [];
        while (!empty($stack)) {
            [$node, $paths] = array_pop($stack);
            if ($node->left === null && $node->right === null) {
                // 叶子节点
                $ans[] = $paths;
            }
            if ($node->left !== null) {
                $stack[] = [$node->left, $paths . '->' . $node->left->val];
            }
            if ($node->right !== null) {
                $stack[] = [$node->right, $paths . '->' . $node->right->val];
            }
        }
        return $ans;
    }

    /**
     * 深度优先遍历带路径
     * @param TreeNode $root
     * @return String[]
     */
    function binaryTreePaths1($root)
    {
        if ($root === null) {
            return [];
        }
        $stack = [[$root, [$root->val]]];
        $ans = [];
        while (!empty($stack)) {
            [$node, $paths] = array_pop($stack);
            if ($node->left === null && $node->right === null) {
                // 叶子节点
                $ans[] = implode('->', $paths);
            }
            if ($node->left !== null) {
                $stack[] = [$node->left, array_merge($paths, [$node->left->val])];
            }
            if ($node->right !== null) {
                $stack[] = [$node->right, array_merge($paths, [$node->right->val])];
            }
        }
        return $ans;
    }
}

$s = new Solution();

$t = new TreeNode(1);
$t->left = new TreeNode(2);
$t->left->right = new TreeNode(5);
$t->right = new TreeNode(3);

var_dump($s->binaryTreePaths($t)); // ['1->2->5', '1->3'];