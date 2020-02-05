<?php

// 给定一个二叉树，返回它的 前序 遍历。
//
// 示例:
//
//输入: [1,null,2,3]
//   1
//    \
//     2
//    /
//   3
//
//输出: [1,2,3]
//进阶: 递归算法很简单，你可以通过迭代算法完成吗？
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/binary-tree-preorder-traversal
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

// 思路
// 前序遍历指的是: 中左右
// 1. 使用递归完成
// 2. 使用栈完成
//   栈的特点是后进先出, 所以需要先进右节点, 后进左节点

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
     * 栈实现
     * @param TreeNode $root
     * @return array
     */
    function preorderTraversal($root)
    {
        if ($root === null) {
            return [];
        }
        $result = [];
        $stack = [];
        // 中加入result, 左右加入栈, 然后出栈继续处理, 直到栈空
        $cur = $root;
        while ($cur !== null || !empty($stack)) {
            $result[] = $cur->val;
            if ($cur->right !== null) {
                $stack[] = $cur->right;
            }
            if ($cur->left !== null) {
                $stack[] = $cur->left;
            }
            $cur = array_pop($stack);
        }
        return $result;
    }

    /**
     * 递归实现
     * @param TreeNode $root
     * @return Integer[]
     */
    function preorderTraversal2($root)
    {
        // 终止条件
        if ($root === null) {
            return [];
        }
        // 迭代
        return array_merge([$root->val], $this->preorderTraversal2($root->left), $this->preorderTraversal2($root->right));
    }
}

$s = new Solution();
$root = new TreeNode(1);
$root->right = new TreeNode(2);
$root->right->left = new TreeNode(3);
$root->right->right  = new TreeNode(4);

var_dump($s->preorderTraversal($root)); // [1, 2, 3]
var_dump($s->preorderTraversal2($root)); // [1, 2, 3]