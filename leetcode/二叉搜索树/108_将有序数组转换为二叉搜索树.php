<?php

// 将一个按照升序排列的有序数组，转换为一棵高度平衡二叉搜索树。
//
//本题中，一个高度平衡二叉树是指一个二叉树每个节点 的左右两个子树的高度差的绝对值不超过 1。
//
//示例:
//
//给定有序数组: [-10,-3,0,5,9],
//
//一个可能的答案是：[0,-3,9,-10,null,5]，它可以表示下面这个高度平衡二叉搜索树：
//
//      0
//     / \
//   -3   9
//   /   /
// -10  5
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/convert-sorted-array-to-binary-search-tree
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

/**
 * Definition for a binary tree node.
 * class TreeNode {
 *     public $val = null;
 *     public $left = null;
 *     public $right = null;
 *     function __construct($value) { $this->val = $value; }
 * }
 */
class Solution
{

    /**
     * 递归解决
     * 时间复杂度: O(n) 每个元素只访问一遍
     * 空间复杂度: O(n) 只储存一次元素
     * 树深度: O(logN)
     * @param Integer[] $nums
     * @return TreeNode
     */
    function sortedArrayToBST($nums)
    {
        return $this->makeTree($nums, 0, count($nums) - 1);
    }

    function makeTree($nums, $start, $end)
    {
        if ($start > $end) {
            return null;
        }
        $center = (int)(($end - $start) / 2) + $start;
        $root = new TreeNode($nums[$center]);
        $root->left = $this->makeTree($nums, $start, $center - 1);
        $root->right = $this->makeTree($nums, $center + 1, $end);
        return $root;
    }
}

$arr = [-10, -3, 0, 5, 9];

$s = new Solution();

//       0
//     / \
//   -3   9
//   /   /
// -10  5
var_dump($s->sortedArrayToBST($arr));