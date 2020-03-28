<?php

// 定义栈的数据结构，请在该类型中实现一个能够得到栈中所含最小元素的min函数（时间复杂度应为O（1））。
//注意：保证测试中不会当栈为空的时候，对栈调用pop()或者min()或者top()方法。

$stack = [];
$min = PHP_INT_MAX;

function mypush($node)
{
    global $stack;
    if (empty($stack)) {
        $min = $node;
    } else {
        $min = min(mymin(), $node);
    }
    $stack[] = ['val' => $node, 'min' => $min];
}

function mypop()
{
    global $stack;
    $item = array_pop($stack);
    return $item['val'];
}

function mytop()
{
    global $stack;
    $len = count($stack);
    if ($len === 0) {
        return null;
    }
    $item = $stack[$len - 1];
    return $item['val'];
}

function mymin()
{
    global $stack;
    $item = $stack[count($stack) - 1];
    return $item['min'];
}

mypush(1);
mypush(2);
mypush(5);
mypush(4);
var_dump(mytop()); // 4
var_dump(mymin()); // 1
var_dump(mypop()); // 4
var_dump(mytop()); // 5
var_dump(mymin()); // 1