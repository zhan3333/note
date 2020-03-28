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
     * 深度优先遍历
     * @param TreeNode $tree
     * @return array
     */
    function inOrderTraversal($tree)
    {
        if ($tree === null) {
            return [];
        }
        $ans = [];
        $stack = [[$tree, [$tree->val]]];
        while (!empty($stack)) {
            [$node, $path] = array_pop($stack);
            if ($node->left === null && $node->right === null) {
                $ans[] = $path;
            }
            if ($node->right !== null) {
                $stack[] = [$node->right, array_merge($path, [$node->right->val])];
            }
            if ($node->left !== null) {
                $stack[] = [$node->left, array_merge($path, [$node->left->val])];
            }
        }
        return $ans;
    }
}

$s = new Solution();

$tree = new TreeNode(3);
$tree->left = new TreeNode(1);
$tree->right = new TreeNode(4);
$tree->left->right = new TreeNode(2);

var_dump($s->inOrderTraversal($tree)); // 1, 2, 3, 4

//var_dump($s->inOrderTraversalRecursion($tree)); // 1, 2, 3, 4
