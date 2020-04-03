<?php

// 给定一个二叉树，它的每个结点都存放着一个整数值。
//
//找出路径和等于给定数值的路径总数。
//
//路径不需要从根节点开始，也不需要在叶子节点结束，但是路径方向必须是向下的（只能从父节点到子节点）。
//
//二叉树不超过1000个节点，且节点数值范围是 [-1000000,1000000] 的整数。
//
//示例：
//
//root = [10,5,-3,3,2,null,11,3,-2,null,1], sum = 8
//
//      10
//     /  \
//    5   -3
//   / \    \
//  3   2   11
// / \   \
//3  -2   1
//
//返回 3。和等于 8 的路径有:
//
//1.  5 -> 3
//2.  5 -> 2 -> 1
//3.  -3 -> 11
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/path-sum-iii
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
    private $pathNumber = 0;

    function pathSum($root, $sum)
    {
        if ($root === null) {
            return 0;
        }
        $this->sum($root, $sum);
        $this->pathSum($root->left, $sum);
        $this->pathSum($root->right, $sum);
        return $this->pathNumber;
    }

    function sum($node, $sum)
    {
        if ($node === null) {
            return;
        }
        $sum -= $node->val;
        if ($sum === 0) {
            $this->pathNumber++;
        }
        $this->sum($node->left, $sum);
        $this->sum($node->right, $sum);
    }
}

$s = new Solution();

$t = new TreeNode(10);
$t->left = new TreeNode(5);
$t->left->left = new TreeNode(3);
$t->left->left->left = new TreeNode(3);
$t->left->left->right = new TreeNode(-1);
$t->left->right = new TreeNode(2);
$t->left->right->right = new TreeNode(1);
$t->right = new TreeNode(-3);
$t->right->right = new TreeNode(11);

var_dump($s->pathSum($t, 8)); // 3