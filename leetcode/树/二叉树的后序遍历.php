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
     * 二叉树后序遍历, 非遍历实现
     * 根左右
     */
    function postOrderTraversa($root)
    {
        $ans = [];
        $stack = [[$root, false]];
        while (!empty($stack)) {
            [$node, $visited] = array_pop($stack);
            if ($node === null) {
                continue;
            }
            if ($visited) {
                $ans[] = $node->val;
            } else {
                $stack[] = [$node, true];
                $stack[] = [$node->right, false];
                $stack[] = [$node->left, false];
            }
        }
        return $ans;
    }

    /**
     * 二叉树后序遍历递归实现
     * @param $root
     * @return array
     */
    function postOrderTraversaRecursion($root)
    {
        if ($root === null) {
            return [];
        }
        $this->helper($root);
        return $this->ans;
    }

    function helper($node)
    {
        if ($node->left !== null) {
            $this->helper($node->left);
        }
        if ($node->right !== null) {
            $this->helper($node->right);
        }
        $this->ans[] = $node->val;
    }
}

$s = new Solution();
$tree = new TreeNode(3);
$tree->left = new TreeNode(1);
$tree->right = new TreeNode(4);
$tree->left->right = new TreeNode(2);

var_dump($s->postOrderTraversa($tree)); // 2, 1, 4, 3

var_dump($s->postOrderTraversaRecursion($tree)); // 2, 1, 4, 3