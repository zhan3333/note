# Zend 虚拟机

## PHP 代码的编译

1. Re2c 语法分析器将 PHP 代码转换为有意义的标识 Token
2. Bison 将 Token 和符合文法规则的代码生成抽象语法树
3. 抽象语法树生成对应的 opcode, 被虚拟机执行. opcode 是 php7 定义的一组指令标识,指令对应着相应的 handler. 当虚拟机调用 opcode,会找到 opcode 背后的处理函数,进行执行

PHP 代码编译为 opcode 数组, 每一个 opcode 代码都有对应的 C 语言里的 struct, 执行过程就是引擎依次执行 opcode

PHP 代码->抽象语法树(AST)->opcodes

PHP 代码->AST: re2c, bison
AST->opcodes: AST->zend_op_array

- zend_op_array
  - zend_op \*opcodes opcode 指令数组
    - handler 每条 opcode 对应 C 语言编写的处理过程
    - op1 操作数 1
    - op2 操作数 2
    - result 返回值
    - opcode opcode 指令
    - op1_type 操作数 1 类型
    - op2_type 操作数 2 类型
    - result_type 返回值类型
  - zval \*literals 字面量数组
  - zend_string \*\*vars 在 AST 编译期间配合 last_var 用来确定各个变量的编号

## 函数实现

PHP 自定义函数的实现就是将函数编译成独立的 opcode 数组,调用时分配独立执行栈依次执行 opcode. 简单可以理解为 opcode 进行了打包封装.

函数的结构

- zend_function

## Zend 引擎执行流程

opcode->execute 这个过程是在 `Zend 引擎`中进行的

opcode 是将 PHP 代码编译产生 Zend 虚拟机可识别的指令,php7 共有 173 个 opcode,定义在`zend_vm_opcodes.h`中, PHP 中所有

## 面向对象实现

## 运行时的缓存

## Opcode
