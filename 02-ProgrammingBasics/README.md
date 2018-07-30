# Programming Basics

Programming is little more that reading data and piecing together statements that take action on that data. This is typically done by making a [decision tree](https://en.wikipedia.org/wiki/Decision_tree). In programming these decision trees are constructed using [control-strucutres](https://en.wikiversity.org/wiki/Control_structures) which tend to flow based upon the current value of a memory addresses most commonly known as a variable.  

## Variables

A variable is an identifier that points to a given memory address (aka: a pointer). The memory address is simply a storage location. The addressing is delt with by the underlying system and is not something we need to worry about for modern/higher level languages. All we need conern oursleves with for the majority of this course is the name of the pointer (the variable name), it's value and it's data type.

In PHP the following statement would reserve a space in memory indentifed by a pointer called ```$a``` and set it value to ```1``` with a data type of ``integer```.

```php
var $a = 1;
```

In Bash the following statement would reserve a space in memory indentifed by a pointer called ```b``` and set it value to ```Hello``` with a data type of ``string``` (kind-of technically (Bash is untyped)(http://tldp.org/LDP/abs/html/untyped.html)).
```bash
b='Hello'
```

In JavaScript the following statement would reserve a space in memory indentifed by a pointer called ```c``` and set its value to a set of given string (as seen bellow) with a data type of ``array```.
```js
var a = [
    'Hello', 
    'World',
    'dog',
    'cat',
    'mouse'
];
```

### Data Types
In short a data type determines how a given variable can be treated, that is to say what operations are allowed on a given varaible.  What is the value of 'Hello' + 1? That depends on the language the the data types. In JavaScript, hello + 1 would return 'Hello1' that is because JavaScript is loosely typed while when working with numbers the ```+``` operator is mathmatical, it also is a used for string concatination when in the string context. Since 'hello' is not a number JavaScript will assume both sides of the equations are a string and as such will performa string concatination rather than than a mathmatical operation. This where we get the meme if 20 + '20' is 2020 you might be a JavaScript developer. In JavaScript 20 + '20' = 2020 but 20 + 20 = 40 this is becasue the latter is 2 numbers while the former is a string and a number.

In PHP ```20 + '20'``` would return 40 and ```'hello' + 1``` would return 1 this is because ```.``` is the operator for concatinating strings and ```+``` is strictly a mathmatical operator. In the former, since the string can be a number it is converted to a number in the later, the value of 'hello' cannot be numeric but PHP will still try to make since of it, so 'hello' equates to 0;

These are both examples of loosley or dynamically typed languages. In a strongly typed language such a Java or TypeScript ```'20' + 20``` would throw a type error.

#### DataTypes in Various Languages
Every language has it's own specific set of data types ad well as it's own set of rules for those types. Most language's will have some notion of the following strings, booleans, numbers, arrays and objects.

* [PHP](http://php.net/manual/en/language.types.intro.php)
* [Bash](http://tldp.org/LDP/abs/html/declareref.html)
* [JavaScript](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Data_structures)
* [TypeScript](https://www.typescriptlang.org/docs/handbook/basic-types.html)


## Control Structures
Assuiming the following variables

variable a is an integer equal to 1
variable b is a string equal to hello
variable c is an array (or set) with the following elements
* Hello
* World
* dog
* cat
* mouse


Based on the afroementioned variables some basic control structures might look like the following

* While variable a is less than 7, call some arbitrary block of logic and increment variable a by 1.
* If varaible a exists as an element of variable b, then return true, else return false.
* foreach element in variable c, check to see if that element is equal to the variable b.







In this section you will learn
* Basic control structures
* The anatomy of a URL/DNS Basics
* The basics of Bash scripting
* The basics of PHP
