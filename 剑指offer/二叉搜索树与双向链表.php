<?php

// 输入一棵二叉搜索树，将该二叉搜索树转换成一个排序的双向链表。
// 要求不能创建任何新的结点，只能调整树中结点指针的指向。

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

function Convert($pRootOfTree)
{
    $stack = [[$pRootOfTree, false]];
    $first = true;
    $head = null;
    $cur = null;
    while (!empty($stack)) {
        [$node, $visited] = array_pop($stack);
        if ($visited) {
            // 遍历到当前节点了
            if ($first) {
                $head = $node;
                $cur = $head;
                $first = false;
            } else {
                $cur->right = $node;
                $node->left = $cur;
                $cur = $cur->right;
            }
        } else {
            if ($node->right !== null) {
                $stack[] = [$node->right, false];
            }
            $stack[] = [$node, true];
            if ($node->left !== null) {
                $stack[] = [$node->left, false];
            }
        }
    }
    return $head;
}

$t = new TreeNode(5);
$t->left = new TreeNode(3);
$t->left->left = new TreeNode(2);
$t->left->left->left = new TreeNode(1);
$t->left->right = new TreeNode(4);
$t->right = new TreeNode(7);
$t->right->left = new TreeNode(6);
$t->right->right = new TreeNode(8);

var_dump(Convert($t)); // 1,2,3,4,5,6,7,8