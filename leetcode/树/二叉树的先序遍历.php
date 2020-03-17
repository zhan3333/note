<?php

class TreeNode
{
    public $val;
    /** @var TreeNode */
    public $left = null;
    /** @var TreeNode */
    public $right = null;

    public function __construct($val)
    {
        $this->val = $val;
    }
}

class Solution
{
    private $ans = [];

    /**
     * 二叉树前序遍历, 非遍历实现
     * 根左右
     */
    function preOrderTraversa($root)
    {
        $stack = [$root];
        $ans = [];
        while (!empty($stack)) {
            $node = array_pop($stack);
            $ans[] = $node->val;
            if ($node->right !== null) {
                $stack[] = $node->right;
            }
            if ($node->left !== null) {
                $stack[] = $node->left;
            }
        }
        return $ans;
    }

    function preOrderTraversaRecursion($root)
    {
        if ($root === null) {
            return [];
        }
        $this->helper($root);
        return $this->ans;
    }

    function helper($node)
    {
        $this->ans[] = $node->val;
        if ($node->left !== null) {
            $this->helper($node->left);
        }
        if ($node->right !== null) {
            $this->helper($node->right);
        }
    }
}

$s = new Solution();
$tree = new TreeNode(3);
$tree->left = new TreeNode(1);
$tree->right = new TreeNode(4);
$tree->left->right = new TreeNode(2);

var_dump($s->preOrderTraversa($tree)); // 3, 1, 2, 4

var_dump($s->preOrderTraversaRecursion($tree)); // 3, 1, 2, 4