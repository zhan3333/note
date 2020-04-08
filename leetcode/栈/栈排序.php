<?php

// 给一个无序的栈, 返回有序的栈

class Solution
{
    /**
     * 空间复杂度: O(n) 使用了一个新栈
     * 时间复杂度: O(n^2) 最坏情况, O(n) 最好情况. 平均 O()n^2
     * @param $stack
     * @return array
     */
    public function sortStack($stack)
    {
        $stack2 = [];
        while (!empty($stack)) {
            $pop = array_pop($stack);
            if (empty($stack2)) {
                $stack2[] = $pop;
            } else if ($pop > $stack2[count($stack2) - 1]) {
                $stack2[] = $pop;
            } else {
                while (!empty($stack2) && $stack2[count($stack2) - 1] > $pop) {
                    $stack[] = array_pop($stack2);
                }
                $stack2[] = $pop;
            }
        }
        return $stack2;
    }
}

$s = new Solution();

var_dump($s->sortStack([4, 5, 1, 3, 2])); // 1,2,3,4,5