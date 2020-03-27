<?php

// 用两个栈来实现一个队列，完成队列的Push和Pop操作。 队列中的元素为int类型。

$stack1 = [];
$stack2 = [];

function mypush($node)
{
    global $stack1, $stack2;
    $stack1[] = $node;
}

function mypop()
{
    global $stack1, $stack2;
    if (empty($stack1) && empty($stack2)) {
        return null;
    }
    if (empty($stack2)) {
        while (!empty($stack1)) {
            $stack2[] = array_pop($stack1);
        }
    }
    return array_pop($stack2);
}