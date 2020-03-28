<?php

// 输入一颗二叉树的根节点和一个整数，
// 打印出二叉树中结点值的和为输入整数的所有路径。
// 路径定义为从树的根结点开始往下一直到叶结点所经过的结点形成一条路径。
// (注意: 在返回值的list中，数组长度大的数组靠前)


class TreeNode
{
    var $val;
    var $left = NULL;
    var $right = NULL;

    function __construct($val)
    {
        $this->val = $val;
    }
}

function FindPath($root, $expectNumber)
{
    if (empty($root)) {
        return [];
    }
    $ans = [];
    // 先来个深度优先遍历
    $stack = [[$root, [$root->val], $root->val]];
    while (!empty($stack)) {
        [$node, $path, $sum] = array_pop($stack);
        if ($node->left === null && $node->right === null && $sum === $expectNumber) {
            $ans[] = $path;
        }
        if ($node->right !== null) {
            $stack[] = [$node->right, array_merge($path, [$node->right->val]), $sum + $node->right->val];
        }
        if ($node->left !== null) {
            $stack[] = [$node->left, array_merge($path, [$node->left->val]), $sum + $node->left->val];
        }
    }
    return $ans;
}

$t = new TreeNode(1);
$t->left = new TreeNode(2);
$t->right = new TreeNode(3);
$t->left->left = new TreeNode(4);
$t->left->right = new TreeNode(5);


var_dump(FindPath($t, 7));