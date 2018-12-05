# Variables

A variable is an identifier that points to a given memory address (aka: a pointer). The memory address is simply a storage location. The addressing is dealt with by the underlying system and is not something we need to worry about for modern/higher level languages. All we need concern ourselves with for the majority of this course is the name of the pointer (the variable name), it's value and it's data type.

In PHP the following statement would reserve a space in memory identified by a pointer called ```$a``` and set it value to ```1``` with a data type of ``integer```.

```php
var $a = 1;
```

In Bash the following statement would reserve a space in memory identified by a pointer called ```b``` and set it value to ```Hello``` with a data type of ``string``` (kind-of technically [Bash is untyped](http://tldp.org/LDP/abs/html/untyped.html)).
```bash
b='Hello'
```

In JavaScript the following statement would reserve a space in memory identified by a pointer called ```c``` and set its value to a set of given string (as seen bellow) with a data type of ``array```.
```js
var a = [
    'Hello', 
    'World',
    'dog',
    'cat',
    'mouse'
];
```
[Next: Data Types](02-DataTypes.md)
