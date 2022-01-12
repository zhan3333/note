# Carbon 问题

## 遇到 UTC 格式字符串时 make 方法无法正确处理时间

遇到这样的字符串 `2019-11-19T17:20:00.610Z`，是ISO时间格式之一，用make不能正确处理

应该使用 `Carbon::parse($str)->tz($timezone)` 来处理成正确的的时间及时区