<?php

// 你现在手里有一份大小为 N x N 的『地图』（网格） grid，上面的每个『区域』（单元格）都用 0 和 1 标记好了。其中 0 代表海洋，1 代表陆地，你知道距离陆地区域最远的海洋区域是是哪一个吗？请返回该海洋区域到离它最近的陆地区域的距离。
//
//我们这里说的距离是『曼哈顿距离』（ Manhattan Distance）：(x0, y0) 和 (x1, y1) 这两个区域之间的距离是 |x0 - x1| + |y0 - y1| 。
//
//如果我们的地图上只有陆地或者海洋，请返回 -1。
//
// 
//
//示例 1：
//
//
//
//输入：[[1,0,1],[0,0,0],[1,0,1]]
//输出：2
//解释：
//海洋区域 (1, 1) 和所有陆地区域之间的距离都达到最大，最大距离为 2。
//示例 2：
//
//
//
//输入：[[1,0,0],[0,0,0],[0,0,0]]
//输出：4
//解释：
//海洋区域 (2, 2) 和所有陆地区域之间的距离都达到最大，最大距离为 4。
// 
//
//提示：
//
//1 <= grid.length == grid[0].length <= 100
//grid[i][j] 不是 0 就是 1
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/as-far-from-land-as-possible
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

class Solution
{

    /**
     * 以左上角为根节点, 进行广度优先遍历
     * @param Integer[][] $grid
     * @return Integer
     */
    function maxDistance($grid)
    {
        $dx = [0, 0, 1, -1];
        $dy = [1, -1, 0, 0];
        $queue = [];
        $m = count($grid);
        $n = count($grid[0]);
        for ($i = 0; $i < $m; $i++) {
            for ($j = 0; $j < $n; $j++) {
                if ($grid[$i][$j] === 1) {
                    $queue[] = [$i, $j];
                }
            }
        }
        $hasOcean = false;
        $point = null;
        $res = -1;
        while (!empty($queue)) {
            $point = array_shift($queue);
            [$x, $y] = $point;
            for ($i = 0; $i < 4; $i++) {
                $newX = $dx[$i] + $x;
                $newY = $dy[$i] + $y;
                if ($newX < 0 || $newY < 0 || $newX >= $n || $newY >= $m || $grid[$newX][$newY] !== 0) {
                    continue;
                }
                $hasOcean = true;
                $grid[$newX][$newY] = $grid[$x][$y] + 1;
                $res = max($grid[$newX][$newY], $res);
                $queue[] = [$newX, $newY];
            }
        }
        if (!$hasOcean || $point === null) {
            return -1;
        }
        return $res - 1;
    }
}

$s = new Solution();

var_dump($s->maxDistance([[1, 0, 1], [0, 0, 0], [1, 0, 1]])); //2
var_dump($s->maxDistance([[1, 0, 0], [0, 0, 0], [0, 0, 0]])); //4
var_dump($s->maxDistance([[0, 0, 0], [0, 0, 0], [0, 0, 0]])); //-1