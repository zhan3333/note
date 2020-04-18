<?php

// 给定一个二叉树，找出其最大深度。
//
//二叉树的深度为根节点到最远叶子节点的最长路径上的节点数。
//
//说明: 叶子节点是指没有子节点的节点。
//
//示例：
//给定二叉树 [3,9,20,null,null,15,7]，
//
//    3
//   / \
//  9  20
//    /  \
//   15   7
//返回它的最大深度 3 。
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/maximum-depth-of-binary-tree
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

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
     * 深度优先遍历递归方式
     * 时间复杂度: O(n)
     * 空间复杂度: O(w)
     * @param $root
     * @return int
     */
    function maxDepth($root)
    {
        if ($root === null) {
            return 0;
        }
        $max = 0;
        $this->helper($root, 0, $max);
        return $max;
    }

    function helper($root, $depth, &$max)
    {
        if ($root !== null) {
            $depth++;
            $max = max($max, $depth);
            $this->helper($root->left, $depth, $max);
            $this->helper($root->right, $depth, $max);
        }
    }

    /**
     * 深度优先遍历, 每个节点储存深度
     * 非递归情况下, 深度优先遍历使用栈来实现
     * 时间复杂度: O(n) 遍历所有节点
     * 空间复杂度: O(w) 二叉树最大宽度
     * @param TreeNode $root
     * @return void
     */
    function maxDepth1($root)
    {
        $max = 0;
        if ($root === null) {
            return $max;
        }
        $stack = [[$root, 1]];
        while (!empty($stack)) {
            [$node, $depth] = array_pop($stack);
            $max = max($depth, $max);
            if ($node->left !== null) {
                $stack[] = [$node->left, $depth + 1];
            }
            if ($node->right !== null) {
                $stack[] = [$node->right, $depth + 1];
            }
        }
        return $max;
    }
}