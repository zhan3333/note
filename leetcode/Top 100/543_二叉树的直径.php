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

class Solution
{
    private $ans = 0;

    /**
     * 一个节点的最大值 = 左子树最大深度 + 右子树最大深度
     * @param TreeNode $root
     * @return Integer
     */
    function diameterOfBinaryTree($root)
    {
        $this->deep($root);
        return $this->ans;
    }

    /**
     * 返回节点的最大深度
     * @param $node
     * @return int|mixed
     */
    function deep($node)
    {
        if ($node === null) {
            return -1;
        }
        $left = $node->left ? $this->deep($node->left) + 1 : 0;
        $right = $node->right ? $this->deep($node->right) + 1 : 0;
        $this->ans = max($left + $right, $this->ans);
        return max($left, $right);
    }
}