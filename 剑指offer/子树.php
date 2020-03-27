<?php

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

function HasSubtree($r1, $r2)
{
    if ($r1 === null || $r2 === null) {
        return false;
    }
    return judgeTree($r1, $r2) ||
        judgeTree($r1->left, $r2) ||
        judgeTree($r1->right, $r2);
}

function judgeTree($r1, $r2)
{
    if ($r1 === null && $r2 === null) {
        return true;
    }
    if ($r1 === null || $r2 === null) {
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