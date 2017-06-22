# [PHP Control Structures](http://php.net/manual/en/language.control-structures.php)

Programming is little more that reading data and piecing together statements that take action on that data. Every language will have it's own set of control structures. For most languages a given set of control structures will be almost identical. In the Bash lesson we learned only a control structures most of which exist in PHP.

## Exercise 2

Add the following to the path /var/www/mtbc/php/exercise2.php.
````
<?php

//Initialize your variables
$label = null;
$color = null;

//Check for get parameters
if(!empty($_GET)){
    $color = "#{$_GET['color']}";
}

//Can we name the color by it's hex value
if($color == "#ff0000"){
  $label = "red";
}elseif($color == "#00ff00"){
  $label = "green";
}elseif($color == "#0000ff"){
  $label = "blue";
}else{
  $label = "unknown";
}

//Output the data
echo "<div style=\"color:{$color}\">The color is {$label}</div>";
````

Now open a browser and navigate to https://localhost/mtbc/php/exercise2.php and you will see the message _The color is unknown_. Now add the following string to the end of the URL [_?color=ff0000_](https://localhost/mtbc/php/exercise2.php). Now your message will read _The color is red_ and it will be written in red font. That string you added to the end of the URL is know as a [query string](https://en.wikipedia.org/wiki/Query_string). A query string allows you to pass arguments into a URL. A query string consists of the query string Identifier (a question mark) _?_ and a series of key to value pairs that are separated by an ampersand (_&_). In our example the the _key is color_ color_ and the _value is ff0000_. If you wanted to submit a query of a first and last name that might look like _?first=bob&last=smith_ where first and last are your keys (aka your GET params) bob and smith are your values.

Now let's take a close look at the code. Initializing your variables is a [good practice](https://stackoverflow.com/questions/30955639/is-it-necessary-to-initialize-declare-variable-in-php).
````
//Initialize your variables
$label = null;
$color = null;
````

In PHP ````$_GET```` is a [superglobal](http://php.net/manual/en/language.variables.superglobals.php) so it is always available, this is NOT something you want to try to initialize. [````empty()````](http://php.net/manual/en/function.empty.php) is used to determine if a variable is [truthy or falsey](https://stackoverflow.com/questions/19839952/all-falsey-values-in-javascript) where falsey values equate to empty or falsey returns true. Prefixing ````empty()```` with an _!_ ````!empty()```` reverses the return values. In plain English ````if(!empty($_GET['color'])){```` would read _if $_GET['color'] is not false then do something_ or you could say _if $_GET['color'] has any value then do something_. You will see a lot of curly braces in PHP code due to it's use of [C style syntax](https://en.wikipedia.org/wiki/C_syntax).

_If $_GET['color'] has any value then the set the variable $color to the value of $_GET['color']_
````
//Check for get parameters
if(!empty($_GET['color'])){ //This is a control statement
    //This is the body of the statement
    $color = "#{$_GET['color']}";
}
````

The user has submitted a hex value in the form of a get parameter. Do we know what to the call that hex value? If the answer is yes set the value of _$label_ to that color. Otherwise set the value of _$label_ to _Unknown_. Or you could say _if the hex value is red then say it is red; otherwise if it green then say it is green; otherwise if it blue then say it is blue; otherwise say unknown_.
````
//Can we name the color by it's hex value
if($color == "#ff0000"){
  $label = "red";
}elseif($color == "#00ff00"){
  $label = "green";
}elseif($color == "#0000ff"){
  $label = "blue";
}else{
  $label = "unknown";
}
````

Finally we will print some output back to the screen. This time we will wrap the output in some HTML to give it  a little style by setting the font color to that of the user input.

````
echo "<div style=\"color:{$color}\">The color is {$label}</div>";
````
