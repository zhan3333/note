<?php

//使用栈实现队列的下列操作：
//
//push(x) -- 将一个元素放入队列的尾部。
//pop() -- 从队列首部移除元素。
//peek() -- 返回队列首部的元素。
//empty() -- 返回队列是否为空。
//示例:
//
//MyQueue queue = new MyQueue();
//
//queue.push(1);
//queue.push(2);
//queue.peek();  // 返回 1
//queue.pop();   // 返回 1
//queue.empty(); // 返回 false
//说明:
//
//你只能使用标准的栈操作 -- 也就是只有 push to top, peek/pop from top, size, 和 is empty 操作是合法的。
//你所使用的语言也许不支持栈。你可以使用 list 或者 deque（双端队列）来模拟一个栈，只要是标准的栈操作即可。
//假设所有操作都是有效的 （例如，一个空的队列不会调用 pop 或者 peek 操作）。
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/implement-queue-using-stacks
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

// 思路:
// push时将数据放在栈底
// pop取栈顶
// peek时取栈顶

// or
// push放栈顶
// pop取栈底
// peek取栈底

// 注意
// 每次操作时, 可以将stack1作为输入栈, stack2作为输出栈, 这样可以避免栈互相转换的消耗, 需要时才进行操作
// push 不影响 peek, 所以 push时可以直接push到stack1上

// 最终方法:
// a, b stack分开用, 当 pop或者peek 时, 若b为空, 则将a全部压入到b中使用
// 在这个方法中, a栈作为一个缓冲作用, 只用来push存值, 当 b中的数据使用完后, 一次性将a压入b中继续使用

class MyQueue
{
    private $stack1;
    private $stack2;

    /**
     * Initialize your data structure here.
     */
    function __construct()
    {
        $this->stack1 = new SplStack();
        $this->stack2 = new SplStack();
    }

    /**
     * Push element x to the back of queue.
     * @param Integer $x
     */
    function push($x)
    {
        $this->stack1->push($x);
    }

    /**
     * Removes the element from in front of queue and returns that element.
     * @return Integer
     */
    function pop()
    {
        if ($this->stack2->isEmpty()) {
            while (!$this->stack1->isEmpty()) {
                $this->stack2->push($this->stack1->pop());
            }
        }
        return $this->stack2->pop();
    }

    /**
     * Get the front element.
     * @return Integer
     */
    function peek()
    {
        if ($this->stack2->isEmpty()) {
            while (!$this->stack1->isEmpty()) {
                $this->stack2->push($this->stack1->pop());
            }
        }
        $pop = $this->stack2->pop();
        $this->stack2->push($pop);
        return $pop;
    }

    /**
     * Returns whether the queue is empty.
     * @return Boolean
     */
    function empty()
    {
        return $this->stack1->isEmpty() && $this->stack2->isEmpty();
    }
}

/**
 * Your MyQueue object will be instantiated and called as such:
 * $obj = MyQueue();
 * $obj->push($x);
 * $ret_2 = $obj->pop();
 * $ret_3 = $obj->peek();
 * $ret_4 = $obj->empty();
 */

$obj = new MyQueue();
$obj->push(1);
$obj->push(2);
var_dump($obj->peek()); // 1
var_dump($obj->pop()); // 1
var_dump($obj->peek()); // 2