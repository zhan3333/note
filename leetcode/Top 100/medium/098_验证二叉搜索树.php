<?php

// 给定一个二叉树，判断其是否是一个有效的二叉搜索树。
//
//假设一个二叉搜索树具有如下特征：
//
//节点的左子树只包含小于当前节点的数。
//节点的右子树只包含大于当前节点的数。
//所有左子树和右子树自身必须也是二叉搜索树。
//示例 1:
//
//输入:
//    2
//   / \
//  1   3
//输出: true
//示例 2:
//
//输入:
//    5
//   / \
//  1   4
//     / \
//    3   6
//输出: false
//解释: 输入为: [5,1,4,null,null,3,6]。
//     根节点的值为 5 ，但是其右子节点值为 4 。
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/validate-binary-search-tree
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

class Solution
{
    private $prev = null;

    /**
     * 中序递归判断
     * @param $root
     */
    function isValidBST($root)
    {
        if ($root === null) {
            return true;
        }
        if ($this->isValidBST($root->left)) {
            if ($this->prev !== null && $this->prev >= $root->val) {
                return false;
            }
            $this->prev = $root->val;
            return $this->isValidBST($root->right);
        }
        return false;
    }


    /**
     * 中序遍历看是否有序
     * @param TreeNode $root
     * @return Boolean
     */
    function isValidBST1($root)
    {
        if ($root === null) {
            return true;
        }
        $stack = [[$root, false]];
        $prev = PHP_INT_MIN;
        while (!empty($stack)) {
            [$node, $visited] = array_pop($stack);
            if ($visited) {
                if ($node->val <= $prev) {
                    return false;
                }
                $prev = $node->val;
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
        return true;
    }
}