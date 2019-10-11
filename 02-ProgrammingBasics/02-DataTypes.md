# Data Types
In short a data type determines how a given variable can be treated, that is to say, what operations are allowed on a given variable.  What is the value of 'Hello' + 1? Well, that depends on the language. 

In JavaScript, hello + 1 would return 'Hello1', that is because JavaScript is loosely typed. When working with numbers, the ```+``` operator is mathematical. When working with strings the ```+``` operator is used for string concatenation. Since 'hello' is a String and not a number (NaN) JavaScript will assume both sides of the equation are strings. Since JavaScript, assumes String, JavaScript will perform a string concatenation rather than a mathematical operation. This where we get the meme if 20 + '20' is 2020 you might be a JavaScript developer. In JavaScript, 20 + '20' = 2020 but 20 + 20 = 40 this is because the latter is 2 numbers while the former is a string and a number. JavaScript reads any value in quotations as a string "20" (String), '20'(String), 20(number).

In PHP ```20 + '20'``` would return 40 and ```'hello' + 1``` would return 1. While PHP is a loosely typed it treats operators differently. In PHP  ```+``` is strictly a mathematical operator. As such, PHP assumes both sides of the equation are numbers. In the former, since the string can be a number it is converted to a number in the later, the value of 'hello' cannot be numeric but PHP will still try to make sense of it, so 'hello' equates to 0;

These are both examples of loosely or dynamically typed languages. In a strongly typed language such a Java or TypeScript ```'20' + 20``` would throw a type error.

## DataTypes in Various Languages
Every language, has it's own specific set of data types, as well as its own set of rules for those types. Most languages, will have some notion of the following data types 
* **strings** - For most languages, this is anything in quotes or anything in quotes and lacking a mathematical operator. ```'Hello', "20", "Hello World"``` would all be examples of strings.
* **booleans** - True or false, generally speaking, ```'true'``` (note the quotes) is not a boolean value while ```true``` is a boolean value.
* **numbers** - For most languages, this would include all unquoted numbers; in some languages this would include strings with mathematical operators. Typical examples include ```10, 20, 30```; or in some languages (PHP) a mathematical operator ```'10' + '20' + "30"``` could cause a string to become numeric.
* **null** - no value, no effect, nothing, nil, empty, zero.
* **arrays** - An array is a variable that contains other variables that are identified as key-to-value pairs. In the example, ```a = ['A', 'B', 'C']``` ```a[0]``` would equate to **A**  and ```a = ['A', 'B', 'C']``` ```a[0]``` would equate to **B**.
* **objects** - Primarily found in higher-level languages, an object can be thought of as a container for properties. Properties consist of variables (data for a given instance) and methods (actions to take on an instance). For example a ```File``` object might have properties such as ```open()```, ```read()```, ```write()```, or ```size```. I might invoke the method open ```File.open()``` which could then allow me to read from ```File.read()``` or write to ```File.write('Hello, I\'m content')``` the file. ```File.size```, (notice the lack of parenthesis) would be the data about a given instance.

You are encouraged to read up on data types by following the links below.
* [PHP](http://php.net/manual/en/language.types.intro.php)
* [Bash](http://tldp.org/LDP/abs/html/declareref.html)
* [JavaScript](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Data_structures)
* [TypeScript](https://www.typescriptlang.org/docs/handbook/basic-types.html)

[Next: Control Structures](03-ControlStructures.md)


this is because ```.``` is the operator for concatenating strings and

An array is a variable that contains other variables that are identified as key-to-value pairs.