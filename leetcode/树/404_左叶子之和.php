<?php

// 计算给定二叉树的所有左叶子之和。
//
//示例：
//
//    3
//   / \
//  9  20
//    /  \
//   15   7
//
//在这个二叉树中，有两个左叶子，分别是 9 和 15，所以返回 24
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/sum-of-left-leaves
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
     * 层序遍历
     * @param TreeNode $root
     * @return Integer
     */
    function sumOfLeftLeaves($root)
    {
        if ($root === null) {
            return 0;
        }
        $queue = [$root];
        $ans = 0;
        while (!empty($queue)) {
            $node = array_shift($queue);
            if ($node->left !== null) {
                if ($node->left->left === null && $node->left->right === null) {
                    $ans += $node->left->val;
                }
                $queue[] = $node->left;
            }
            if ($node->right !== null) {
                $queue[] = $node->right;
            }
        }
        return $ans;
    }
}

$t = new TreeNode(3);
$t->left = new TreeNode(9);
$t->right = new TreeNode(20);
$t->right->left = new TreeNode(15);
$t->right->right = new TreeNode(7);

$s = new Solution();

var_dump($s->sumOfLeftLeaves($t)); // 24