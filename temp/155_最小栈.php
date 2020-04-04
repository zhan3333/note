<?php

class MinStack
{
    private $stack = [];

    /**
     * 时间复杂度: O(1)
     */
    public function getMin()
    {
        return $this->stack[count($this->stack) - 1][1] ?? null;
    }

    public function push($value)
    {
        $min = $this->getMin();
        $this->stack[] = [$value, $min !== null ? min($value, $min) : $value];
    }

    public function top()
    {
        return $this->stack[count($this->stack) - 1][0];
    }

    public function pop()
    {
        $pop = array_pop($this->stack);
        return $pop[0];
    }
}

$stack = new MinStack();

$stack->push(-2);
$stack->push(0);
$stack->push(-3);
var_dump($stack->getMin()); // -3
$stack->pop();
var_dump($stack->top()); // 0
var_dump($stack->getMin()); // -2