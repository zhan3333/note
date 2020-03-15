<?php

// 给定一个二叉搜索树, 找到该树中两个指定节点的最近公共祖先。
//
//百度百科中最近公共祖先的定义为：“对于有根树 T 的两个结点 p、q，最近公共祖先表示为一个结点 x，满足 x 是 p、q 的祖先且 x 的深度尽可能大（一个节点也可以是它自己的祖先）。”
//
//例如，给定如下二叉搜索树:  root = [6,2,8,0,4,7,9,null,null,3,5]
//
//
//
// 
//
//示例 1:
//
//输入: root = [6,2,8,0,4,7,9,null,null,3,5], p = 2, q = 8
//输出: 6
//解释: 节点 2 和节点 8 的最近公共祖先是 6。
//示例 2:
//
//输入: root = [6,2,8,0,4,7,9,null,null,3,5], p = 2, q = 4
//输出: 2
//解释: 节点 2 和节点 4 的最近公共祖先是 2, 因为根据定义最近公共祖先节点可以为节点本身。
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/lowest-common-ancestor-of-a-binary-search-tree
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

class TreeNode
{
    public $val = null;
    /** @var TreeNode */
    public $left = null;
    /** @var TreeNode */
    public $right = null;

    public function __construct($val)
    {
        $this->val = $val;
    }
}

class Solution
{
    /**
     * 利用二叉搜索树的特点, 当搜索时节点在(p, q)之间时, 这个节点就是p,q的最近公共祖先
     * 时间复杂度: O(n)
     * 空间复杂度: O(1)
     * @param TreeNode $root
     * @param TreeNode $p
     * @param TreeNode $q
     * @return TreeNode
     */
    function lowestCommonAncestor($root, $p, $q)
    {
        $cur = $root;
        while ($cur !== null) {
            if ($cur->val >= $p->val && $cur->val <= $q->val) {
                return $cur;
            }
            if ($cur->val > $p->val && $cur->val > $q->val) {
                $cur = $cur->left;
            }
            if ($cur->val < $p->val && $cur->val < $q->val) {
                $cur = $cur->right;
            }
        }
        return null;
    }
}

$s = new Solution();

$t = new TreeNode(6);
$t->left = new TreeNode(2);
$t->right = new TreeNode(8);
$t->left->left = new TreeNode(0);
$t->left->right = new TreeNode(4);
$t->left->right->left = new TreeNode(3);
$t->left->right->right = new TreeNode(5);
$t->right->left = new TreeNode(7);
$t->right->right = new TreeNode(9);

var_dump($s->lowestCommonAncestor($t, new TreeNode(2), new TreeNode(8))); // 6