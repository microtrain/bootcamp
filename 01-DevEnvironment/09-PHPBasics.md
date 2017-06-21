# PHP Basics

PHP (the P in LAMP stack) is a popular server side scripting language. Once you have a LAMP server up an running, getting started with PHP is pretty easy.

Since this is a dev environment we want to able to debug errors. Lets tell Apache to show us errors when accessing PHP files.

````
sudo vim /etc/php/7.0/apache2/php.ini
````

Find the ````display_errors```` directive by typing ````display_errors =```` in vim. This will be around line 426 enter insert mode and change ````display_errors = On```` to ````display_errors = Off```` then restart Apache.


## Exercise 1
From Atom's side navigation create the path _/var/www/mtbc/php/hello.php_. Then open the hello.php file.

Add the following lines to _/var/www/mtbc/php/hello.php_

````php
<?php
//Greets the user with the current date and time.

//Create a date object http://php.net/manual/en/book.datetime.php from PHP's built
$date = new DateTime();

//Format the date http://php.net/manual/en/datetime.formats.date.php
$formattedDate = $date->format('Y-m-d h:i:s');

echo "Hello it is {$formattedDate}";
````

PHP tags denote which part of a file is to be parsed as PHP ````<?php //php code goes here ?>````. The closing tag ````?>```` is only required if the last line of a file is not PHP. As a best practice ["The closing ````?>```` tag MUST be omitted from files containing only PHP."](http://www.php-fig.org/psr/psr-2/)

PHP has three types of comments.
* ````// Comment here````
* ````# Comment here````
* ````/* Comment here */

Variable in PHP are denoted by a dollar sign. Unlike bash, the dollar sign MUST always be present.


Open a browser and navigate to https://localhost/php/hello.php. You will see the string _Hello it is x_ where x is the current date and time.

Now lets have a look at what we wrote, don't worry if you do not get this, we will go over it all again when we dive into the programming lessons.

The first line is ````<?php````, this tells the server to begin interpreting PHP. PHP tags open with ````<?php```` and close with ````?>```` if there is no closing tag it is assumed all text after ````<?php```` is PHP.

Line two is a comment ````//Greets...```` in PHP single line comments start with either ````//```` or ````#```` the PHP interpreter ingores everything between ````//```` or ````#```` and the end of the line. Comments are user to communicate with other programmers and to remind yourself why did something. PHP also supports multi-line comments with an opening and closing tag ````/* this is a comment */````

Line 4 creates an object, in the case the object is an instance of the date class ````$date = new DateTime();````

* ````$date```` - this is a variable that will hold an instance of the DateTime() class (The instantiated object)
* ````new```` - says I want to create a new copy (instantiate an object) of a class.
* ````DateTime()```` - the class to be instantiated.

Line 7 stores the result of an operation in a variable called ````$formattedDate````.
````format()```` is a method (a type of property) of the ````DateTime()```` class.
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

````echo "Hello it is {$formattedDate}";````

* ````echo```` - Tells PHP to write something to a web page.
* ````""```` - Defines the string to be written, everything inside the quotes will
be printed.
* ````$formattedDate```` - The formatted date string.
* ```{}```` - Not required, but makes it easier to separate variables from strings.

Now lets push your code to GitHub. Log into to your GitHub account and create a
repo called ````php_basics```` and push your repository to GitHub

````
cd /var/www/php_basics
git init
git add .
git commit -m "first commit"
git remote add origin git@github.com:[github_username]/php_basics.git
git push -u origin master
````  

[Next: Git](09-Git.md)
