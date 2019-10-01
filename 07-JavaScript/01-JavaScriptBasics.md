# JavaScript Basics
JavaScript is simple programming language created by Netscape's Brendan Eich in 1995. The goal was to make web pages more interactive by allowing the browser to execute native code without the need of a plugin. JavaScript was standardized by ECMA  thus providing a standard implementation reference. While we still call it JavaScript the reference standard is [ECMA-262](https://www.ecma-international.org/publications/standards/Ecma-262.htm)

## Exercises
Modern browsers make use of DevTools (aka Web Console). While Chrome, FireFox and Edge have similar definitions for their DevTools, I'll steal this line from Chrome's documentation "Use the DevTools to iterate, debug, and profile your site".

* [Chrome](https://developers.google.com/web/tools/chrome-devtools/console/)
* [FireFox](https://developer.mozilla.org/en-US/docs/Tools/Web_Console)
* [Edge](https://docs.microsoft.com/en-us/microsoft-edge/f12-devtools-guide/console)

Create the file ```/var/www/mtbc/js/console.html``` that contains the following markup.

```html
<!DOCTYPE html>
<html>
  <head>
      <title>Using the development console.</title>
  </head>
  <body>
    <p>Using the development console. Press [f12] and click the console tab.</p>
    <script>
      console.log();
    </script>
  </body>
</html>
```

### Exercise 1 - Print data to the console

#### Exercise 1.1 - Pass a static string as an argument
Find the ```<script>``` tags in the markup you just added to the new file. You will see a single line of code that reads ```console.log()```. Modify this line to read ```console.log('Hello World');```. Then open a browser and navigate to [http://localhost/mtbc/js/console.html(http://localhost/mtbc/js/console.html). Once the page opens, press [f12] and click on the console tab. You will see the text _Hello World_ followed by the file name and line number.

##### Notes
The command ```console.log()``` call the log() function from the console API. This is what is know as dot concatenation, in this case ```log()``` is a property (method, function or variable) of the ```console``` API. This syntax is also used in object oriented programming (OOP) in which it would read something like ```ObjectX.propertyY``` or  ```ObjectX.methodZ()```. Some languages such a PHP use ```->``` instead of a dot, but the idea is the same ```$ObjectX->propertyY``` or ```$ObjectX->methodZ()```.

While not required, most function (or method) calls will accept an argument. In this case, the console APIs ```log()``` method accepts a single parameter, the data to be printed to the screen. This data may be of any type number, string, array, object, etc. In exercise 1.1 we passed a static string. You can read more about JavaScript data types [here](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Data_structures).

#### Exercise 1.2 - Pass a variable as an argument
Modify the contents of the script tags to read as follows.

```js
var msg = 'Hello World';
console.log(msg);
```

In this exercise we are creating the variable msg (which is a common variable name for message) and assigning it a value of _Hello World_.

#### Exercise 1.3 - Working with strings
Modify the contents of the script tags to read as follows.

```js
var greeting =  'Hello';
var who = 'World';
var msg = greeting + ' ' + who;

console.log(msg);
```

In this example we are combining the value of two variables and assigning the result to the ```msg``` variable.

#### Exercise 1.4 - Working with numbers
Modify the contents of the script tags to read as follows.

```js
var num1 =  35;
var num2 = 7;
var result = num1 + num2;

console.log(result);
```

In this example we are adding the values of ```num1``` and ```num2```.

##### Notes
Notice we are not adding quotes to the value of these variables. That is because we want to treat these values as numbers not strings. This will only work with numbers, if we were to set the value of ```num1``` to _ab_ instead of _'ab'_ we would get an error, this is because _ab_ is not a number. If on the other hand, we had a variable named ```ab``` and that variable had a numeric value, it would treat ```ab``` as a numeric data type.

#### Exercise 1.4 - Working with mixed data types
Modify the contents of the script tags to read as follows.

```js
var num1 =  '35';
var num2 = 7;
var result = num1 + num2;

console.log(result);
```

As in the previous example we are adding _7_ to _35_, only this time we have added quotes to _35_. Adding quotes changes the data type from a number to a string so rather than adding two numeric values we are concatenating two strings.

##### Notes
JavaScript is loosely typed, meaning it will try to resolve the data type in to something that makes since to a given problem. Since, in this case we are adding a number to a string the JavaScript interpreter will conclude (since a number can always fit into a string, but a string cannot always fit into a number) that we are attempting to concatenate two strings rather than add two numbers which will result in a value of _357_.

### Exercise 2 - Write to the page
Duplicate ```/var/www/mtbc/js/console.html``` to ```/var/www/mtbc/js/write.html``` that contains the following markup and add an element of type ```div``` to the body of the HTML document. Give the ```div``` an attribute of type ```id``` with a value of _MyText_ ```<div id="MyText"></div>```.

#### Exercise 2.1 - Working with mixed data types
Replace the contents of the script tags with the following.

```js
var msg = 'Hello World';

document.getElementById('MyText').innerHTML = msg;
```
Checkyour changes at [http://localhost/mtbc/js/write.html(http://localhost/mtbc/js/write.html)

In this exercise we are calling the ```getElementById()``` method of the ```document``` API. This accepts a single attribute and that is the id of the element we want to access. ```innerHTML``` is a property of the element. This property represents all of the content that appears between the opening and closing tags of the target element. In the exercise we are setting the value of ```innerHTML```.

#### Exercise 2.1 - Working with mixed data types
In the js.html file change ```<div id="MyText"></div>``` to ```<div id="MyText">Hello World</div>``` and add a new element ```<div id="NewText"></div>```

Inside the script tags, write some JavaScript that will read the content of _MyText_ and write it to _NewText_.

##### Notes
The ```innerHTML``` property hold the content of a target element.

## Additional Resources
* [MDN - JavaScript](https://developer.mozilla.org/en-US/docs/Web/JavaScript)
* [Eloquent_JavaScript](http://eloquentjavascript.net/Eloquent_JavaScript.pdf)
* [Douglas Crawford](http://javascript.crockford.com/)

[Next: JavaScript Control Structures](02-JSControlStructures.md)
