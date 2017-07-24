# HTML Forms

Traditionally, forms have been the most common way to collect data from a user. A form submission is the simplest way to post data to a server. This section will start with a simple POST request and end with complex processing.


## Simple Form

Create the following paths.
````
/var/www/mtbc/exercises/html/forms/form.html
/var/www/mtbc/exercises/php/forms/form.php
````

/var/www/mtbc/html/forms/form.html
````
<form method="post" action="http://localhost/mtbc/php/forms/form.php">
  <input type="text" name="first_name">
  <input type="text" name="last_name">
  <input type="text" name="email">
</form>
````

/var/www/mtbc/php/forms/form.php
````
<?php

$data = $_POST;

foreach($data as $key => $value){
  echo "{$key} = {$value}";
}
````

## Validation and Basic RegEx

Create the following paths.
````
/var/www/mtbc/exercises/html/forms/regex_form.html
/var/www/mtbc/exercises/php/forms/regex_form.php
````

/var/www/mtbc/html/forms/regex_form.html
````
<form method="post" action="http://localhost/mtbc/php/forms/regex_form.php">
  <input type="text" name="first_name">
  <input type="text" name="last_name">
  <input type="text" name="email">
</form>
````

/var/www/mtbc/php/forms/regex_form.php
````
<?php
//Create a RegEx pattern to determine the validity of the use submitted email
//allow up to two strings with dot concatenation any letter, any case any number with _- before the @
//require @
//allow up to two strings with dot concatenation any letter, any case any number with - after the at
//require at least 2 letters and only letters for the domain
$validEmail = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/";

//Extract $_POST to a data array
$data = $_POST;

//Create an empty array to hold any error we detect
$errors = [];

foreach($data as $key => $value){
  echo "{$key} = {$value}<br><br>";

  //Use a switch statement to change your behavior based upon the form field
  switch($key){
      case 'email':
        if(preg_match($validEmail, $value)!==1){
            $errors[$key] = "Invalid email";
        }

      break;

      default:
        if(empty($value)){
            $errors[$key] = "Invalid {$key}";
        }
      break;
  }

}

var_dump($errors);
````

Regular Expressions are extremely powerful, flexible and worth learning.having said that there are a million and one libraries for validating form submissions. I would advise finding well supported library that meets your projects needs. As of PHP5 [data filters](http://php.net/manual/en/book.filter.php) have been natively supported by the language.

*Security Check Point*
_Never trust user input. User input is anything come into the server from the client. Even if you have written client side JavaScript to filter out malicious code, the filtered input is still left alone with the client and can be manipulated prior to transit (or even in transit). If it has ever existed outside of the server it CANNOT be trusted._



## Additional Reading
* [Email RegEx Examples](http://emailregex.com/)
