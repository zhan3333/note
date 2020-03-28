<?php

// 输入一个整数数组，判断该数组是不是某二叉搜索树的后序遍历的结果。
//如果是则输出Yes,否则输出No。假设输入的数组的任意两个数字都互不相同。
//
// 后序遍历: 左->右->中
// 二叉搜索树: 左 < 中 < 右
// 后序遍历的二叉搜索树最后一个元素是根节点, 去除最后一个元素后, 前边的元素一半是左节点, 一半是右节点
// 有 左节点 < 根 < 右节点, 如果不符合这个排序的, 就不是二叉搜索树


function VerifySquenceOfBST($sequence)
{
    $len = count($sequence);
    if ($len === 0) {
        return false;
    }
    return isBST($sequence, 0, $len - 1);
}

function isBST($sequence, $start, $end)
{
    if ($start >= $end) {
        return true;
    }
    $endVal = $sequence[$end];
    $mid = $start - 1;
    for ($i = $start; $i < $end; $i++) {
        if ($sequence[$i] < $endVal) {
            $mid = $i;
        } else {
            break;
        }
    }
    for ($i = $mid + 1; $i < $end; $i++) {
        if ($sequence[$i] < $endVal) {
            return false;
        }
    }
    return isBST($sequence, $start, $mid) &&
        isBST($sequence, $mid + 1, $end - 1);
}

var_dump(VerifySquenceOfBST([2, 4, 3, 6, 8, 7, 5])); // true
var_dump(VerifySquenceOfBST([4, 6, 7, 5])); // true
var_dump(VerifySquenceOfBST([9, 4, 3, 6, 8, 7, 1])); // false