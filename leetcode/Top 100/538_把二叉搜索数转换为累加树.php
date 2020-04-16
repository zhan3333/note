<?php

// 给定一个二叉搜索树（Binary Search Tree），把它转换成为累加树（Greater Tree)，使得每个节点的值是原来的节点值加上所有大于它的节点值之和。
//
// 
//
//例如：
//
//输入: 原始二叉搜索树:
//              5
//            /   \
//           2     13
//
//输出: 转换为累加树:
//             18
//            /   \
//          20     13
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/convert-bst-to-greater-tree
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

class Solution
{
    private $sum = 0;

    /**
     * 每个节点都累加上右侧所有的节点
     * @param TreeNode $root
     * @return TreeNode
     */
    function convertBST($root)
    {
        if ($root !== null) {
            $this->convertBST($root->right);
            $root->val += $this->sum;
            $this->sum = $root->val;
            $this->convertBST($root->left);
        }
        return $root;
    }


}