<?php

// 翻转一棵二叉树。
//
//示例：
//
//输入：
//
//     4
//   /   \
//  2     7
// / \   / \
//1   3 6   9
//输出：
//
//     4
//   /   \
//  7     2
// / \   / \
//9   6 3   1
//备注:
//这个问题是受到 Max Howell 的 原问题 启发的 ：
//
//谷歌：我们90％的工程师使用您编写的软件(Homebrew)，但是您却无法在面试时在白板上写出翻转二叉树这道题，这太糟糕了。
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/invert-binary-tree
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
    function invertTree($root)
    {
        if ($root === null) {
            return $root;
        }
        $left = $root->left;
        $right = $root->right;
        $root->left = $right;
        $root->right = $left;
        $this->invertTree($left);
        $this->invertTree($right);
        return $root;
    }
}

$t = new TreeNode(4);
$t->left = new TreeNode(2);
$t->right = new TreeNode(7);
$t->left->left = new TreeNode(1);
$t->left->right = new TreeNode(3);
$t->right->left = new TreeNode(6);
$t->right->right = new TreeNode(9);

$s = new Solution();

var_dump($s->invertTree($t)); //