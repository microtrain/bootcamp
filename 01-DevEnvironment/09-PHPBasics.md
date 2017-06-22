# PHP Basics

PHP (the P in LAMP stack) is a popular server side scripting language. Once you have a LAMP server up an running, getting started with PHP is pretty easy.

Since this is a dev environment we want to able to debug errors. Lets tell Apache to show us errors when accessing PHP files.

````
sudo vim /etc/php/7.0/apache2/php.ini
````

Find the _display_errors_ directive by typing _\display_errors =_ in vim. This will be around line 426 enter insert mode and change _display_errors = On_ to _display_errors = Off_ then restart Apache.


## Exercise 1
From Atom's side navigation create the path _/var/www/mtbc/php/exercise1.php_. Then open the hello.php file.

Add the following lines to _/var/www/mtbc/php/exercise1.php_

````php
<?php
/**
 * Greets the user with the current date and time.
 */

//Create a date object http://php.net/manual/en/book.datetime.php from PHP's built
$date = new DateTime();

#Format the date http://php.net/manual/en/datetime.formats.date.php
$formattedDate = $date->format('Y-m-d h:i:s');

echo "Hello it is {$formattedDate}";
````

Open a browser and navigate to https://localhost/mtbc/php/exercise1.php. You will see the string _Hello it is x_ where x is the current date and time.

Now lets have another look at what we wrote, don't worry if you do not get this, we will go over it all again when we dive into the programming lessons.

The first line is ````<?php````, this tells the server to begin interpreting PHP. PHP tags open with ````<?php```` and close with ````?>```` if there is no closing tag it is assumed all text after the opening PHP tag is to interpreted as PHP.

Line 2 is a comment there are three types of comments in PHP.
* ````# This is a comment````
* ````// This is a comment ````  
* ````/* this is a comment */````

Line 4 creates an object<sup>1</sup>, in the case the object is an instance of the date class ````$date = new DateTime();````

* ````$date```` - this is a variable that will hold an instance of the DateTime() class (_$date_ holds the instantiated object)
* ````new```` - says I want to create a new copy (instantiation) of a class.
* ````DateTime()```` - the class to be instantiated. The parenthesis indicate an empty constructor<sup>2</sup>.

Line 7 stores the result of an operation in a variable called ````$formattedDate````.

A method is a property of an object in PHP we can access a propery of an object using an arrow ````->````. ````format()```` is a method (a type of property) of the ````DateTime()```` class.
Here the operation is simply formatting the current Unix timestamp to a human
readable format. ````$date->format('Y-m-d h:i:s')```` says I want to call the _format()_
method of the _$date_ object with the following parameters ````'Y-m-d h:i:s'````.

* ````$formattedDate```` - A variable that holds a formatted date string.
* ````=```` - Sets the value of the left to that of the right.
* ````$date```` - The instantiated date object.
* ````->```` - Object operator, this is used to request properties from an
instantiated object. In most languages use dot concatenation ```` . ````.
* ````format()```` - A method of the DateTime() class, a property of the instantiated
object.
* ````'Y-m-d h:i:s'```` - A parameter for the format method. In this case we are
providing a string representation of what we want the formatted date to look like.

In the final line we are printing results to the screen.

* ````echo```` - Tells PHP to write something to a web page.
* ````""```` - Defines the string to be written, everything inside the quotes will
be printed.
* ````$formattedDate```` - The formatted date string.
* ````{}```` - Not required, but makes it easier to separate variables from strings.


## Footnotes
<sup>1</sup> PHP supports both procedural (functional) programming and object oriented programming (OOP). In OOP an instantiated class is an object. A class could be considered a blue print for an object. PHP has a built in class for working with dates called _DateTime_. PHP instantiates classes with the ````new```` operator. The line ````$date = new DateTime();```` stores an instance of the _ DateTime_ object in a variable called _$date_. PHP uses an arrow  ````->```` as it's [Object Operator](https://stackoverflow.com/questions/2588149/what-is-the-php-operator-called-and-how-do-you-say-it-when-reading-code-out). To access the _format_ method of the _DateTime_ class you would say ````$date->format();````. In this case we are storing the formatted date in the variable _formattedDate_. As in Bash, PHP uses _echo_ to write content to the screen. In this case, a web page.

<sup>2</sup> An empty constructor, constructor with no argument. In programming arguments allow us to pass data into objects, methods and functions.

[Next: Git](09-Git.md)
