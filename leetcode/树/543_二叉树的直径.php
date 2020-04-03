<?php

// 给定一棵二叉树，你需要计算它的直径长度。一棵二叉树的直径长度是任意两个结点路径长度中的最大值。这条路径可能穿过也可能不穿过根结点。
//
// 
//
//示例 :
//给定二叉树
//
//          1
//         / \
//        2   3
//       / \
//      4   5
//返回 3, 它的长度是路径 [4,2,1,3] 或者 [5,2,1,3]。
//
// 
//
//注意：两结点之间的路径长度是以它们之间边的数目表示。
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/diameter-of-binary-tree
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
    public $max = 0;

    /**
     * 最大直径不一定是过根节点, 所以所有的节点都需要判断一次直径
     * 节点的最大直径 = max(左节点最大深度 + 右节点最大深度)
     * 时间复杂度: O(n) 每个节点访问一次
     * 空间复杂度: O(Height) 递归执行了树的高度次
     * @param TreeNode $root
     * @return Integer
     */
    function diameterOfBinaryTree($root)
    {
        if ($root === null) {
            return 0;
        }
        $this->setDepth($root);
        return $this->max;
    }

    /**
     * 获取树的最大深度
     * @param $root
     * @return int
     */
    function setDepth($root)
    {
        if ($root !== null) {
            $left = $this->setDepth($root->left);
            $right = $this->setDepth($root->right);
            $this->max = max($this->max, $left + $right);
            return max($left, $right) + 1;
        }
        return 0;
    }
}

$s = new Solution();

$t = new TreeNode(1);
$t->left = new TreeNode(2);
$t->left->left = new TreeNode(4);
$t->left->right = new TreeNode(5);
$t->right = new TreeNode(3);
$t->right->left = new TreeNode(6);

var_dump($s->diameterOfBinaryTree($t)); // 4