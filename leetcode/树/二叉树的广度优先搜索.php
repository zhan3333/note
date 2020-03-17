<?php

class TreeNode
{
    public $val = null;
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
    /**
     * 广度优先搜索
     * @param TreeNode $tree
     * @return array
     */
    function inOrderTraversal($tree)
    {

    }
}

$s = new Solution();

$tree = new TreeNode(3);
$tree->left = new TreeNode(1);
$tree->right = new TreeNode(4);
$tree->left->right = new TreeNode(2);

var_dump($s->inOrderTraversal($tree)); // 1, 2, 3, 4

var_dump($s->inOrderTraversalRecursion($tree)); // 1, 2, 3, 4
