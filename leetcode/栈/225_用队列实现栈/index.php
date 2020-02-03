<?php

//使用队列实现栈的下列操作：
//
//push(x) -- 元素 x 入栈
//pop() -- 移除栈顶元素
//top() -- 获取栈顶元素
//empty() -- 返回栈是否为空
//注意:
//
//你只能使用队列的基本操作-- 也就是 push to back, peek/pop from front, size, 和 is empty 这些操作是合法的。
//你所使用的语言也许不支持队列。 你可以使用 list 或者 deque（双端队列）来模拟一个队列 , 只要是标准的队列操作即可。
//你可以假设所有操作都是有效的（例如, 对一个空的栈不会调用 pop 或者 top 操作）。
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/implement-stack-using-queues
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

// 思考
// 注意这道理只能在类中使用队列的入队出队,size,isEmpty功能, 而不能使用SplQueue中允许的类似栈的操作
// 方案: 使用双队列
// push 时将queue1数据移到queue2中, 然后enqueue push的数据, 然后将queue2的数据转到queue1中
// pop 直接 dequeue

// 最终思路
// a除了push时临时存一个值, 其他时候都为空
// b存队列, head放栈顶, bottom放栈底

// 2. 单队列实现思路
// 使用计数的方式, 将队列pop出来再push

class MyStack
{

    private $queue1;
    private $queue2;

    /**
     * Initialize your data structure here.
     */
    function __construct()
    {
        $this->queue1 = new SplQueue();
        $this->queue2 = new SplQueue();
    }

    /**
     * Push element x onto stack.
     * @param Integer $x
     */
    function push($x)
    {
        $this->queue1->enqueue($x);
        while (!$this->queue2->isEmpty()) {
            $this->queue1->enqueue($this->queue2->dequeue());
        }
        $temp = $this->queue1;
        $this->queue1 = $this->queue2;
        $this->queue2 = $temp;
    }

    /**
     * Removes the element on top of the stack and returns that element.
     * @return Integer
     */
    function pop()
    {
        return $this->queue2->dequeue();
    }

    /**
     * Get the top element.
     * @return Integer
     */
    function top()
    {
        return $this->queue2->bottom();
    }

    /**
     * Returns whether the stack is empty.
     * @return Boolean
     */
    function empty()
    {
        return $this->queue2->isEmpty();
    }
}

/**
 * Your MyStack object will be instantiated and called as such:
 * $obj = MyStack();
 * $obj->push($x);
 * $ret_2 = $obj->pop();
 * $ret_3 = $obj->top();
 * $ret_4 = $obj->empty();
 */
$obj = new MyStack();
$obj->push(1);
$obj->push(2);
var_dump($obj->top());  // 2
var_dump($obj->pop());  // 2
var_dump($obj->top());  // 1
var_dump($obj->empty());    // false