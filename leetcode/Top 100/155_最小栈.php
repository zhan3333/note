<?php

// 设计一个支持 push ，pop ，top 操作，并能在常数时间内检索到最小元素的栈。
//
//push(x) —— 将元素 x 推入栈中。
//pop() —— 删除栈顶的元素。
//top() —— 获取栈顶元素。
//getMin() —— 检索栈中的最小元素。
//示例:
//
//MinStack minStack = new MinStack();
//minStack.push(-2);
//minStack.push(0);
//minStack.push(-3);
//minStack.getMin();   --> 返回 -3.
//minStack.pop();
//minStack.top();      --> 返回 0.
//minStack.getMin();   --> 返回 -2.
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/min-stack
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

class MinStack
{
    private $stack = [];

    /**
     * 时间复杂度: O(1)
     */
    public function getMin()
    {
        if (empty($this->stack)) {
            return null;
        }
        return $this->stack[count($this->stack) - 1][1];
    }

    public function push($value)
    {
        if (empty($this->stack)) {
            $min = $value;
        } else {
            $min = min($value, $this->stack[count($this->stack) - 1][1]);
        }
        $this->stack[] = [$value, $min];
    }

    public function top()
    {
        if (empty($this->stack)) {
            return null;
        }
        return $this->stack[count($this->stack) - 1][0];
    }

    public function pop()
    {
        $value = $this->top();
        if ($value !== null) {
            array_pop($this->stack);
        }
        return $value;
    }
}