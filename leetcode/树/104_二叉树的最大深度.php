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
     * 队列实现
     * @param $root
     * @return int|mixed
     */
    function maxDepth($root)
    {
        // 储存子树和深度
        $queue = [[$root, 1]];
        $max = 0;
        while (!empty($queue)) {
            [$tree, $deep] = array_shift($queue);
            if ($tree !== null) {
                $max = max($max, $deep);
                $queue[] = [$tree->left, $deep + 1];
                $queue[] = [$tree->right, $deep + 1];
            }
        }
        return $max;
    }

    /**
     * 递归实现
     * @param TreeNode $root
     * @return Integer
     */
    function maxDepth1($root)
    {
        return $root === null ? 0 : (1 + max($this->maxDepth($root->left), $this->maxDepth($root->right)));
    }
}

$t = new TreeNode(3);
$t->left = new TreeNode(9);
$t->right = new TreeNode(20);
$t->right->left = new TreeNode(15);
$t->right->right = new TreeNode(7);

$s = new Solution();
var_dump($s->maxDepth($t)); // 3