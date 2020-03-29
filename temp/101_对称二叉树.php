<?php

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

    function isSymmetric($root)
    {
        $queue = [$root];
        while (!empty($queue)) {
            $n = count($queue);
            $arr = [];
            for ($i = 0; $i < $n; $i++) {
                $node = array_shift($queue);
                $arr[] = $node->val ?? PHP_INT_MIN;
                if ($node !== null) {
                    $queue[] = $node->left;
                    $queue[] = $node->right;
                }
            }
            $mid = (int)($n / 2);
            for ($i = 0; $i <= $mid; $i++) {
                if ($arr[$i] !== $arr[$n - $i - 1]) {
                    return false;
                }
            }
        }
        return true;
    }
}

$s = new Solution();

$root = new TreeNode(1);
$root->left = new TreeNode(2);
$root->right = new TreeNode(2);
$root->left->left = new TreeNode(3);
$root->left->right = new TreeNode(4);
$root->right->left = new TreeNode(4);
$root->right->right = new TreeNode(3);

var_dump($s->isSymmetric($root)); // true