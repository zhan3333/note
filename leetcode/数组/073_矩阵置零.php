<?php

/*
 * @lc app=leetcode.cn id=73 lang=php
 *
 * [73] 矩阵置零
 */

// @lc code=start
class Solution
{

    /**
     * 使用两个hash表储存需要置0的行数, 由于要区分新0和旧0, 所以需要先遍历一遍获取到所有的旧0, 然后再使用hash表对行列进行置零
     * @param Integer[][] $matrix
     * @return NULL
     */
    function setZeroes(&$matrix)
    {
        $h = count($matrix);
        $w = count($matrix[0]);
        $hashI = [];
        $hashJ = [];
        for ($i = 0; $i < $h; $i++) {
            for ($j = 0; $j < $w; $j++) {
                if ($matrix[$i][$j] === 0) {
                    $hashI[$i] = true;
                    $hashJ[$j] = true;
                }
            }
        }
        $arrI = array_keys($hashI);
        $arrJ = array_keys($hashJ);
        for ($i = 0, $iMax = count($arrI); $i < $iMax; $i++) {
            for ($t = 0; $t < $w; $t++) {
                $matrix[$arrI[$i]][$t] = 0;
            }
        }
        for ($j = 0, $jMax = count($arrJ); $j < $jMax; $j++) {
            for ($t = 0; $t < $h; $t++) {
                $matrix[$t][$arrJ[$j]] = 0;
            }
        }
    }
}
// @lc code=end

