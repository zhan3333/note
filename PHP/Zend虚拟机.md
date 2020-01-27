# Zend 虚拟机

## PHP 代码的编译

1. Re2c 语法分析器将 PHP 代码转换为有意义的标识 Token
2. Bison 将 Token 和符合文法规则的代码生成抽象语法树
3. 抽象语法树生成对应的 opcode, 被虚拟机执行. opcode 是 php7 定义的一组指令标识,指令对应着相应的 handler. 当虚拟机调用 opcode,会找到 opcode 背后的处理函数,执行整整

## 函数实现

## Zend 引擎执行流程

## 面向对象实现

## 运行时的缓存

## Opcode
