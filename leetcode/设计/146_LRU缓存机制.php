<?php

// 运用你所掌握的数据结构，设计和实现一个  LRU (最近最少使用) 缓存机制。它应该支持以下操作： 获取数据 get 和 写入数据 put 。
//
//获取数据 get(key) - 如果密钥 (key) 存在于缓存中，则获取密钥的值（总是正数），否则返回 -1。
//写入数据 put(key, value) - 如果密钥不存在，则写入其数据值。当缓存容量达到上限时，它应该在写入新数据之前删除最久未使用的数据值，从而为新的数据值留出空间。
//
//进阶:
//
//你是否可以在 O(1) 时间复杂度内完成这两种操作？
//
//示例:
//
//LRUCache cache = new LRUCache( 2 /* 缓存容量 */ );
//
//cache.put(1, 1);
//cache.put(2, 2);
//cache.get(1);       // 返回  1
//cache.put(3, 3);    // 该操作会使得密钥 2 作废
//cache.get(2);       // 返回 -1 (未找到)
//cache.put(4, 4);    // 该操作会使得密钥 1 作废
//cache.get(1);       // 返回 -1 (未找到)
//cache.get(3);       // 返回  3
//cache.get(4);       // 返回  4
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/lru-cache
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

Class ListNode
{
    public $key = null;
    public $value = null;
    /** @var ListNode */
    public $next = null;
    /** @var ListNode */
    public $prev = null;

    public function __construct($key, $value = null)
    {
        $this->key = $key;
        $this->value = $value;
    }
}

/**
 * 题目要求 get, put 均为 O(1) 时间复杂度, 并且能淘汰做不常使用的key
 * 显然, hash get, put 复杂度为 O(1)
 * 而淘汰不常用的key, 需要用 O(1) 复杂度删除, 可以选择使用双向链表, 可以 O(1) 来操作删除
 * 使用双向链表 + hash表实现
 *
 * Class LRUCache
 */
class LRUCache
{
    private $capacity;
    private $hash = [];
    private $head;
    private $tail;

    /**
     * @param Integer $capacity
     */
    function __construct($capacity)
    {
        $this->capacity = $capacity;
        // 创建双端链表
        $this->head = new ListNode(null);
        $this->tail = new ListNode(null);
        $this->head->next = $this->tail;
        $this->tail->prev = $this->head;
    }

    function removeHeadNode()
    {
        $node = $this->head->next;
        $this->removeNode($node);
    }

    function removeNode(ListNode $node)
    {
        $prev = $node->prev;
        $next = $node->next;
        $prev->next = $next;
        $next->prev = $prev;
        unset($this->hash[$node->key]);
    }

    function moveNodeToTail(ListNode $node)
    {
        $this->removeNode($node);
        $this->addNodeToTail($node);
    }

    function addNodeToTail(ListNode $node)
    {
        $next = $this->tail;
        $prev = $this->tail->prev;
        $node->next = $next;
        $next->prev = $node;
        $prev->next = $node;
        $node->prev = $prev;

        $this->hash[$node->key] = $node;
    }

    /**
     * @param Integer $key
     * @return Integer
     */
    function get($key)
    {
        if (isset($this->hash[$key])) {
            $node = $this->hash[$key];
            // 将节点放到队列尾
            $this->moveNodeToTail($node);
            return $node->value;
        }
        return -1;
    }

    /**
     * @param Integer $key
     * @param Integer $value
     * @return NULL
     */
    function put($key, $value)
    {
        if (isset($this->hash[$key])) {
            $node = $this->hash[$key];
            $this->removeNode($node);
        } elseif (count($this->hash) === $this->capacity) {
            // 超出容量了, 移除队列头部
            $this->removeHeadNode();
        }
        // 增加key
        $node = new ListNode($key, $value);
        $this->addNodeToTail($node);
    }
}

/**
 * Your LRUCache object will be instantiated and called as such:
 * $obj = LRUCache($capacity);
 * $ret_1 = $obj->get($key);
 * $obj->put($key, $value);
 */

$obj = new LRUCache(2);

$obj->put(1, 1);
$obj->put(2, 2);
var_dump($obj->get(1));   // 1
$obj->put(3, 3); // 2被淘汰了
var_dump($obj->get(2)); // -1
$obj->put(4, 4); // 1淘汰了
var_dump($obj->get(3));   // 3
var_dump($obj->get(4));   // 4