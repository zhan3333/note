<?php

// 输入某二叉树的前序遍历和中序遍历的结果，请重建出该二叉树。
// 假设输入的前序遍历和中序遍历的结果中都不含重复的数字。
// 例如输入前序遍历序列{1,2,4,7,3,5,6,8}和中序遍历序列{4,7,2,1,5,3,8,6}，则重建二叉树并返回。

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

function reConstructBinaryTree($pre, $vin)
{
    if (empty($pre) || empty($vin)) {
        return null;
    }
    $tree = new TreeNode($pre[0]);
    $len = count($vin);
    for ($midIndex = 0; $midIndex < $len; $midIndex++) {
        if ($tree->val === $vin[$midIndex]) {
            break;
        }
    }
    var_dump($midIndex);
    $left = array_slice($vin, 0, $midIndex);
    $right = array_slice($vin, $midIndex + 1, count($vin) - $midIndex - 1);
    $tree->left = reConstructBinaryTree(array_slice($pre, 1, count($left)), $left);
    $tree->right = reConstructBinaryTree(array_slice($pre, count($left) + 1, count($right)), $right);

    return $tree;
}

var_dump(reConstructBinaryTree([1, 2, 4, 7, 3, 5, 6, 8], [4, 7, 2, 1, 5, 3, 8, 6]));