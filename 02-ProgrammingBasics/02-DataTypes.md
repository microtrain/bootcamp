# Data Types
In short a data type determines how a given variable can be treated, that is to say what operations are allowed on a given varaible.  What is the value of 'Hello' + 1? That depends on the language the the data types. In JavaScript, hello + 1 would return 'Hello1' that is because JavaScript is loosely typed while when working with numbers the ```+``` operator is mathmatical, it also is a used for string concatination when in the string context. Since 'hello' is not a number JavaScript will assume both sides of the equations are a string and as such will performa string concatination rather than than a mathmatical operation. This where we get the meme if 20 + '20' is 2020 you might be a JavaScript developer. In JavaScript 20 + '20' = 2020 but 20 + 20 = 40 this is becasue the latter is 2 numbers while the former is a string and a number.

In PHP ```20 + '20'``` would return 40 and ```'hello' + 1``` would return 1 this is because ```.``` is the opera*tor for concatinating strings and ```+``` is strictly a mathmatical operator. In the former, since the string can be a number it is converted to a number in the later, the value of 'hello' cannot be numeric but PHP will still try to make since of it, so 'hello' equates to 0;

These are both examples of loosley or dynamically typed languages. In a strongly typed language such a Java or TypeScript ```'20' + 20``` would throw a type error.

## DataTypes in Various Languages
Every language has it's own specific set of data types ad well as it's own set of rules for those types. Most languages will have some notion of the following data types strings, booleans, numbers, null, arrays and objects.

* [PHP](http://php.net/manual/en/language.types.intro.php)
* [Bash](http://tldp.org/LDP/abs/html/declareref.html)
* [JavaScript](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Data_structures)
* [TypeScript](https://www.typescriptlang.org/docs/handbook/basic-types.html)
