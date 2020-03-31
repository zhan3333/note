<?php

// 把只包含质因子2、3和5的数称作丑数（Ugly Number）。
// 例如6、8都是丑数，但14不是，因为它包含质因子7。
// 习惯上我们把1当做是第一个丑数。
// 求按从小到大的顺序的第N个丑数。


function GetUglyNumber_Solution($index)
{
    if ($index <= 0) {
        return 0;
    }
    $n1 = 0;
    $n2 = 0;
    $n3 = 0;
    $ans = [1];
    for ($i = 1; $i < $index; $i++) {
        $ans[$i] = min($ans[$n1] * 2, $ans[$n2] * 3, $ans[$n3] * 5);
        if ($ans[$i] === $ans[$n1] * 2) $n1++;
        if ($ans[$i] === $ans[$n2] * 3) $n2++;
        if ($ans[$i] === $ans[$n3] * 5) $n3++;
    }
    return $ans[$index - 1];
}

var_dump(GetUglyNumber_Solution(10));