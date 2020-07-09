package leetcode_golang

import "math"

//编写一个函数来查找字符串数组中的最长公共前缀。
//
// 如果不存在公共前缀，返回空字符串 ""。 
//
// 示例 1: 
//
// 输入: ["flower","flow","flight"]
//输出: "fl"
// 
//
// 示例 2: 
//
// 输入: ["dog","racecar","car"]
//输出: ""
//解释: 输入不存在公共前缀。
// 
//
// 说明: 
//
// 所有输入只包含小写字母 a-z 。 
// Related Topics 字符串

//type DictTree map[int32]DictTree

//leetcode submit region begin(Prohibit modification and deletion)

type D struct {
	Val     int32
	Childes map[int32]*D
}

func (d *D) Insert(v int32) {
	if _, ok := d.Childes[v]; !ok {
		d.Childes[v] = &D{
			Val:     v,
			Childes: map[int32]*D{},
		}
	}
}

func longestCommonPrefix(strs []string) string {
	// 建一个字典树
	tree := &D{
		Val:     0,
		Childes: map[int32]*D{},
	}
	min := math.MaxInt64
	for _, str := range strs {
		cur := tree
		min = int(math.Min(float64(min), float64(len(str))))
		for _, c := range str {
			cur.Insert(c)
			cur = cur.Childes[c]
		}
	}
	ret := ""
	cur := tree
	for len(cur.Childes) == 1 {
		for k, child := range cur.Childes {
			ret += string(k)
			cur = child
			break
		}
	}
	if len(ret) > min {
		return ret[0:min]
	}
	return ret
}


//leetcode submit region end(Prohibit modification and deletion)
