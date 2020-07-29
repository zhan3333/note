package leetcode_golang

//给定一个整数数组，判断是否存在重复元素。 
//
// 如果任意一值在数组中出现至少两次，函数返回 true 。如果数组中每个元素都不相同，则返回 false 。 
//
// 
//
// 示例 1: 
//
// 输入: [1,2,3,1]
//输出: true 
//
// 示例 2: 
//
// 输入: [1,2,3,4]
//输出: false 
//
// 示例 3: 
//
// 输入: [1,1,1,3,3,4,3,2,4,2]
//输出: true 
// Related Topics 数组 哈希表0

//leetcode submit region begin(Prohibit modification and deletion)
func containsDuplicate(nums []int) bool {
	m := map[int]interface{}{}
	for _, n := range nums {
		if _, ok := m[n]; ok {
			return true
		}
		m[n] = nil
	}
	return false
}

//leetcode submit region end(Prohibit modification and deletion)
