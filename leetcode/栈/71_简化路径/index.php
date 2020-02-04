<?php

// 以 Unix 风格给出一个文件的绝对路径，你需要简化它。或者换句话说，将其转换为规范路径。
//
//在 Unix 风格的文件系统中，一个点（.）表示当前目录本身；此外，两个点 （..） 表示将目录切换到上一级（指向父目录）；两者都可以是复杂相对路径的组成部分。更多信息请参阅：Linux / Unix中的绝对路径 vs 相对路径
//
//请注意，返回的规范路径必须始终以斜杠 / 开头，并且两个目录名之间必须只有一个斜杠 /。最后一个目录名（如果存在）不能以 / 结尾。此外，规范路径必须是表示绝对路径的最短字符串。
//
// 
//
//示例 1：
//
//输入："/home/"
//输出："/home"
//解释：注意，最后一个目录名后面没有斜杠。
//示例 2：
//
//输入："/../"
//输出："/"
//解释：从根目录向上一级是不可行的，因为根是你可以到达的最高级。
//示例 3：
//
//输入："/home//foo/"
//输出："/home/foo"
//解释：在规范路径中，多个连续斜杠需要用一个斜杠替换。
//示例 4：
//
//输入："/a/./b/../../c/"
//输出："/c"
//示例 5：
//
//输入："/a/../../b/../c//.//"
//输出："/c"
//示例 6：
//
//输入："/a//b////c/d//././/.."
//输出："/a/b/c"
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/simplify-path
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

// 思考
// 需要转换成绝对路径, 需要符合以下条件
// 1. 最后一个字符不能是/
// 2. 根目录为 / , 再往上还是 /
// 3. . 为当前目录, .. 为父目录
// 4. /与/不能放在一起
// 5. 规范路径必须是表示绝对路径的最短路径
//
// 这个问题不能用逐个读取字符串来解决, 而应该先通过 / 拆分字符串为数组, 然后遍历数组来操作栈
// . 不需要操作
// .. pop
// default push

class Solution {

    /**
     * @param String $path
     * @return String
     */
    function simplifyPath($path) {
        $stack = [];
        $arr = explode('/', $path);
        foreach ($arr as $item) {
            switch ($item) {
                case '.':
                case '':
                    break;
                case '..':
                    if (!empty($stack)) {
                        array_pop($stack);
                    }
                    break;
                default:
                    $stack[] = $item;
            }
        }
        return '/' . implode('/', $stack);
    }
}

$s = new Solution();
var_dump($s->simplifyPath('/home/')); // /home
var_dump($s->simplifyPath('/../')); // /
var_dump($s->simplifyPath('/home//foo/')); // /home/foo
var_dump($s->simplifyPath('/a/./b/../../c/')); // /c
var_dump($s->simplifyPath('/a/../../b/../c//.//')); // /c
var_dump($s->simplifyPath('/a//b////c/d//././/..')); // /a/b/c


