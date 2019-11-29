# Laravel Faker 使用中文

有时候需要使用 faker 来生成中国的的手机号，所以需要修改 faker 为中文

app.php 中配置　`'faker_locale' => 'zh_CN'` 来进行

获取　`$faker` 实例: `app(Faker\Generator::class)`
