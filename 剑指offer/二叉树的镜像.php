<?php

// 操作给定的二叉树，将其变换为源二叉树的镜像。


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

function Mirror(&$root)
{
    if ($root === null) {
        return $root;
    }
    $temp = $root->left;
    $root->left = $root->right;
    $root->right = $temp;
    Mirror($root->left);
    Mirror($root->right);
}

$t = new TreeNode(8);
$t->left = new TreeNode(6);
$t->right = new TreeNode(10);
$t->left->left = new TreeNode(5);
$t->left->right = new TreeNode(7);
$t->right->left = new TreeNode(9);
$t->right->right = new TreeNode(11);

Mirror($t);

var_dump($t);