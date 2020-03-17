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
    private $recursionAns = [];

    /**
     * 中序遍历, 非递归做法, 使用栈来实现
     * @param TreeNode $tree
     * @return array
     */
    function inOrderTraversal($tree)
    {
        $ans = [];
        $stack = [[$tree, false]];
        while (!empty($stack)) {
            [$node, $visited] = array_pop($stack);
            if ($node === null) {
                continue;
            }
            if ($visited) {
                $ans[] = $node->val;
            } else {
                $stack[] = [$node->right, false];
                $stack[] = [$node, true];
                $stack[] = [$node->left, false];
            }
        }
        return $ans;
    }

    /**
     * 中序遍历, 非递归做法, 使用栈来实现
     * @param TreeNode $tree
     * @return array
     */
    function inOrderTraversal2($tree)
    {
        $ans = [];
        $node = $tree;
        $stack = [];
        while (!empty($stack) || $node !== null) {
            if ($node !== null) {
                $stack[] = $node;
                $node = $node->left;
            } else {
                $node = array_pop($stack);
                $ans[] = $node->val;
                $node = $node->right;
            }
        }
        return $ans;
    }

    function inOrderTraversalRecursion($tree)
    {
        if ($tree === null) {
            return [];
        }
        $this->recursionHelper($tree);
        return $this->recursionAns;
    }

    function recursionHelper($tree)
    {
        if ($tree->left !== null) {
            $this->inOrderTraversalRecursion($tree->left);
        }
        $this->recursionAns[] = $tree->val;
        if ($tree->right !== null) {
            $this->inOrderTraversalRecursion($tree->right);
        }
    }
}

$s = new Solution();

$tree = new TreeNode(3);
$tree->left = new TreeNode(1);
$tree->right = new TreeNode(4);
$tree->left->right = new TreeNode(2);

var_dump($s->inOrderTraversal($tree)); // 1, 2, 3, 4

var_dump($s->inOrderTraversalRecursion($tree)); // 1, 2, 3, 4
