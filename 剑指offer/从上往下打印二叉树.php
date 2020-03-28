<?php

// 从上往下打印出二叉树的每个节点，同层节点从左至右打印。
// 二叉树的广序遍历

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

function PrintFromTopToBottom($root)
{
    if (empty($root)) {
        return [];
    }
    $queue = [$root];
    $ans = [];
    while (!empty($queue)) {
        $node = array_shift($queue);
        if ($node !== null) {
            $ans[] = $node->val;
            $queue[] = $node->left;
            $queue[] = $node->right;
        }
    }
    return $ans;
}

$t = new TreeNode(1);
$t->left = new TreeNode(2);
$t->right = new TreeNode(3);
$t->left->left = new TreeNode(4);
$t->left->right = new TreeNode(5);

var_dump(PrintFromTopToBottom($t)); // 12345