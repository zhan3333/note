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
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/convert-bst-to-greater-tree
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

class TreeNode
{
    public $val = null;
    public $left = null;
    public $right = null;

    function __construct($value)
    {
        $this->val = $value;
    }
}

class Solution
{

    /**
     * @param TreeNode $root
     * @return TreeNode
     */
    function convertBST($root)
    {
        if ($root === null) {
            return null;
        }
        $stack = [[$root, false]];
        $sum = 0;
        while (!empty($stack)) {
            [$node, $visit] = array_pop($stack);
            if ($visit) {
                $node->val += $sum;
                $sum = $node->val;
            } else {
                if ($node->left !== null) {
                    $stack[] = [$node->left, false];
                }
                $stack[] = [$node, true];
                if ($node->right !== null) {
                    $stack[] = [$node->right, false];
                }
            }
        }
        return $root;
    }


}

$t = new TreeNode(5); // 18
$t->left = new TreeNode(2); // 20
$t->right = new TreeNode(13); // 13

$s = new Solution();

var_dump($s->convertBST($t)); //