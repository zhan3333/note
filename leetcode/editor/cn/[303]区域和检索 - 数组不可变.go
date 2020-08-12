package leetcode_golang

//给定一个整数数组 nums，求出数组从索引 i 到 j (i ≤ j) 范围内元素的总和，包含 i, j 两点。 
//
// 示例： 
//
// 给定 nums = [-2, 0, 3, -5, 2, -1]，求和函数为 sumRange()
//
//sumRange(0, 2) -> 1
//sumRange(2, 5) -> -1
//sumRange(0, 5) -> -3 
//
// 说明: 
//
// 
// 你可以假设数组不可变。 
// 会多次调用 sumRange 方法。 
// 
// Related Topics 动态规划

//leetcode submit region begin(Prohibit modification and deletion)
type NumArray struct {
	Nums []int
	Sums []int
}

func Constructor(nums []int) NumArray {
	arr := NumArray{
		Nums: nums,
		Sums: []int{},
	}
	if len(nums) > 0 {
		arr.Sums = append(arr.Sums, nums[0])
		for i := 1; i < len(nums); i++ {
			arr.Sums = append(arr.Sums, arr.Sums[i-1]+nums[i])
		}
	}
	return arr
}

func (this *NumArray) SumRange(i int, j int) int {
	if i == 0 {
		return this.Sums[j]
	}
	return this.Sums[j] - this.Sums[i-1]
}

/**
 * Your NumArray object will be instantiated and called as such:
 * obj := Constructor(nums);
 * param_1 := obj.SumRange(i,j);
 */
//leetcode submit region end(Prohibit modification and deletion)
