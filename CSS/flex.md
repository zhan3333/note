# flex

[MDN Flex 弹性盒子](https://developer.mozilla.org/zh-CN/docs/Learn/CSS/CSS_layout/Flexbox)

**flex-direction: column / row(default)**

指定主轴的方向是 row 还是 column

**flex-wrap： wrap / nowrap / wrap-reverse**

超出行容量后是否换行

**flex-direction 与 flex-wrap 缩写**

`flex-flow: row wrap;`

**flex 比例**

`flex: 1;` 值代表比例
`flex: 1 200px;` 表示最小宽度为 200px

**flex 缩写与全写**

`flex {flex-grow} {flex-shrink} {flex-basis}`

- flex-grow (number, 默认 0): 指定容器还有多余的空间时按照比例分配多余空间
- flex-shrink (number, 默认 1): 指定容器空间不足时，从每个 flex 中取出多少空间来防止 flex 溢出容器
- flex-basic(默认 auto): 指定 flex 初始大小，也可以理解为最小大小

`flex 1;` 缩写，指定了 flex-grow 属性

**水平对齐**

```
{
    display: flex;
    align-items: center;
    justify-content: space-around;
}
```

- align-items: 控制 flex 项在交叉轴上的位置
    - stretch： 默认，容器的交叉轴有固定宽度时，flex 项会拉伸填充容器；如果没有固定宽度时，所有的 flex 项将变得与最长的 flex
      一样长。
    - center: 交叉轴居中
    - flex-start / flex-end
- align-self: 属性与 align-items 一致, 覆盖 align-items 行为，flex 项定义自身的行为
- align-content: 控制 flex 项在交叉轴上的位置，对 `flex-wrap: nowrap` 无效
    - center
    - flex-start / flex-end
    - start / end
    - space-between
    - space-around
    - stretch: 拉伸，填充满容器
- justify-content: 控制 flex 项在主轴上的位置
    - center: flex 项在主轴居中
    - flex-start、flex-end
    - space-around: 使所有 flex 项在主轴上均匀分步，在两端同样的留有空间
    - space-between: 和 space-around 类型，但是两端不留空间
- justify-items (flex 布局中会被忽略)
- justify-self (flex 布局中会被忽略)

**嵌套**

如果一个元素为 flex 项，那么他同样成为一个 flex 容器。