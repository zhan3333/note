package leetcode_golang

import "sort"

//给出一个区间的集合，请合并所有重叠的区间。
//
// 
//
// 示例 1: 
//
// 输入: intervals = [[1,3],[2,6],[8,10],[15,18]]
//输出: [[1,6],[8,10],[15,18]]
//解释: 区间 [1,3] 和 [2,6] 重叠, 将它们合并为 [1,6].
// 
//
// 示例 2: 
//
// 输入: intervals = [[1,4],[4,5]]
//输出: [[1,5]]
//解释: 区间 [1,4] 和 [4,5] 可被视为重叠区间。 
//
// 注意：输入类型已于2019年4月15日更改。 请重置默认代码定义以获取新方法签名。 
//
// 
//
// 提示： 
//
// 
// intervals[i][0] <= intervals[i][1] 
// 
// Related Topics 排序 数组

//leetcode submit region begin(Prohibit modification and deletion)

type IntervalsSlice [][]int

func (p IntervalsSlice) Len() int           { return len(p) }
func (p IntervalsSlice) Less(i, j int) bool { return p[i][0] < p[j][0] }
func (p IntervalsSlice) Swap(i, j int)      { p[i], p[j] = p[j], p[i] }

func merge(intervals [][]int) [][]int {
	sort.Sort(IntervalsSlice(intervals))
LOOP:
	for i := 0; i < len(intervals)-1; i++ {
		if intervals[i][1] >= intervals[i+1][0] {
			left := intervals[i][0]
			right := intervals[i][1]
			if intervals[i][1] < intervals[i+1][1] {
				right = intervals[i+1][1]
			}
			tmp := append(intervals[0:i], []int{left, right})
			intervals = append(tmp, intervals[i+2:]...)
			// 合并完成后, 重新开始循环
			goto LOOP
		}
	}
	return intervals
}

//leetcode submit region end(Prohibit modification and deletion)
