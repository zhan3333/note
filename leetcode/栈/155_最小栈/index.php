<?php

// 设计一个支持 push，pop，top 操作，并能在常数时间内检索到最小元素的栈。
//
//push(x) -- 将元素 x 推入栈中。
//pop() -- 删除栈顶的元素。
//top() -- 获取栈顶元素。
//getMin() -- 检索栈中的最小元素
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/min-stack
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

// 思路
// 在入栈的时候保存最小的值
// 出栈的时候查找下一个最小的值

// 注意
// 出栈到最后一个值时, 需要将min置为null
// 入栈第一个值时, 需要置为min


class MinStack {
    private $stack = [];
    private $min;
    private $topIndex = -1;

    public function __construct()
    {
    }

    public function getMin()
    {
        return $this->min;
    }

    public function push($value)
    {
        $this->stack[] = $value;
        if ($this->min === null) {
            $this->min = $value;
        }
        if ($value < $this->min) {
            $this->min = $value;
        }
        $this->topIndex ++;
    }

    public function top()
    {
        if ($this->topIndex === -1) {
            return null;
        }
        return $this->stack[$this->topIndex];
    }

    public function pop()
    {
        if ($this->topIndex === -1) {
            return null;
        }
        $pop = array_pop($this->stack);
        $this->topIndex -- ;
        if ($this->topIndex !== -1) {
            $this->min = min($this->stack);
        } else {
            $this->min = null;
        }
        return $pop;
    }
}

$minStack = new MinStack();

print_r(min([]));