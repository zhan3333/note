<?php


// 输入n个整数，
//找出其中最小的K个数。
//例如输入4,5,1,6,2,7,3,8这8个数字，则最小的4个数字是1,2,3,4,。


function GetLeastNumbers_Solution($input, $k)
{
    $len = count($input);
    if ($k < 1 || $k > $len) {
        return [];
    }
    $maxHeap = new SplMaxHeap();
    for ($i = 0; $i < $len; $i++) {
        if ($maxHeap->count() < $k) {
            $maxHeap->insert($input[$i]);
        } else {
            if ($maxHeap->top() >= $input[$i]) {
                $maxHeap->extract();
                $maxHeap->insert($input[$i]);
            }
        }
    }
    $ans = [];
    while ($maxHeap->valid()) {
        $ans[] = $maxHeap->current();
        $maxHeap->next();
    }
    return array_reverse($ans);
}

var_dump(GetLeastNumbers_Solution([4, 5, 1, 6, 2, 7, 3, 8], 4)); // 1,2,3,4