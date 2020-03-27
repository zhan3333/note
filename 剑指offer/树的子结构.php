<?php

// 输入两棵二叉树A，B，判断B是不是A的子结构。（ps：我们约定空树不是任意一个树的子结构）


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

function HasSubtree($pRoot1, $pRoot2)
{
    if ($pRoot1 === null || $pRoot2 === null) {
        return false;
    }
    return judgeTree($pRoot1, $pRoot2) ||
        judgeTree($pRoot1->left, $pRoot2) ||
        judgeTree($pRoot1->right, $pRoot2);
}

function judgeTree($r1, $r2)
{
    if ($r2 === null) {
        return true;
    }
    if ($r1 === null) {
        return false;
    }
    if ($r1->val !== $r2->val) {
        return judgeTree($r1->left, $r2) ||
            judgeTree($r1->right, $r2);
    }
    return judgeTree($r1->left, $r2->left) &&
        judgeTree($r1->right, $r2->right);
}


$t1 = new TreeNode(1);
$t1->left = new TreeNode(2);
$t1->left->left = new TreeNode(3);
$t1->left->right = new TreeNode(4);
$t1->left->left->left = new TreeNode(5);
$t1->right = new TreeNode(6);

$t2 = $t1->left;

var_dump(HasSubtree($t1, $t2)); // true