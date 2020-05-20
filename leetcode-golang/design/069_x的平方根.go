package design

func mySqrt(x int) int {
	if x == 0 {
		return 0
	}
	if x < 4 {
		return 1
	}
	l := 2
	r := x - 1
	for l < r {
		m := (r-l)/2 + l
		mul := m * m
		if mul == x {
			return m
		} else if mul < x {
			l = m + 1
		} else {
			r = m - 1
		}
	}
	if l*l > x {
		return l - 1
	} else {
		return l
	}
}
