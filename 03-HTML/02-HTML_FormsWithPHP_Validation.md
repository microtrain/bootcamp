# HTML Forms with PHP Validation

Traditionally, forms have been the most common way to collect data from a user. A form submission is the simplest way to post data to a server. This section will start with a simple POST request and end with complex processing.


## Simple Form

Create the following paths.
````
/var/www/mtbc/exercises/html/forms/form.html
/var/www/mtbc/exercises/php/forms/form.php
````

/var/www/mtbc/exercises/html/forms/form.html
````
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Basic Form Example</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>
  <body>
    <form method="post" action="http://localhost/mtbc/exercises/php/forms/form.php">

      <div>
        <label for="firstName">First Name</label><br>
        <input type="text" name="first_name" id="firstName">
      </div>

      <div>
        <label for="lastName" id="lastName">Last Name</label><br>
        <input type="text" name="last_name">
      </div>

      <div>
        <label for="email" id="email">Email</label><br>
        <input type="text" name="email">
      </div>

      <input type="submit">

    </form>
  </body>
</html>

````

/var/www/mtbc/exercises/php/forms/form.php
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
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Basic Form Example</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>
  <body>
    <form method="post" action="http://localhost/mtbc/exercises/php/forms/regex_form.php">

      <div>
        <label for="firstName">First Name</label><br>
        <input type="text" name="first_name" id="firstName">
      </div>

      <div>
        <label for="lastName" id="lastName">Last Name</label><br>
        <input type="text" name="last_name">
      </div>

      <div>
        <label for="email" id="email">Email</label><br>
        <input type="text" name="email">
      </div>

      <input type="submit">

    </form>
  </body>
</html>

````

/var/www/mtbc/php/exercises/forms/regex_form.php
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

## Single Page App with a Validation Class
/var/www/mtbc/exercises/php/forms/spa.php
````
<?php

class Validate{

    public $validation = [];

    public $errors = [];

    private $data = [];

    public function notEmpty($value){

        if(!empty($value)){
            return true;
        }

        return false;

    }

    public function email($value){

        if(filter_var($value, FILTER_VALIDATE_EMAIL)){
            return true;
        }

        return false;

    }

    public function check($data){

        $this->data = $data;

        foreach(array_keys($this->validation) as $fieldName){

            $this->rules($fieldName);
        }

    }

    public function rules($field){
        foreach($this->validation[$field] as $rule){
            if($this->{$rule['rule']}($this->data[$field]) === false){
                $this->errors[$field] = $rule;
            }
        }
    }

    public function error($field){
        if(!empty($this->errors[$field])){
            return $this->errors[$field]['message'];
        }

        return false;
    }

}

$valid = new Validate();

$input = filter_input_array(INPUT_POST);
if(!empty($input)){

    $valid->validation = [
        'first_name'=>[[
            'rule'=>'notEmpty',
            'message'=>'Please enter your first name'
        ]],
        'last_name'=>[[
            'rule'=>'notEmpty',
            'message'=>'Please enter your last name'
        ]],
        'email'=>[[
                'rule'=>'email',
                'message'=>'Please enter a valid email'
            ],[
                'rule'=>'notEmpty',
                'message'=>'Please enter an email'
        ]],
    ];


    $valid->check($input);
}


?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Single Page App with a Validation Class</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>
  <body>

    <?php if(empty($valid->errors) && !empty($input)): ?>
      <div>Success!</div>
    <?php else: ?>
      <div>You page has errors.</div>
    <?php endif; ?>

    <form method="post" action="spa.php">

      <div>
        <label for="firstName">First Name</label><br>
        <input type="text" name="first_name" id="firstName">
        <div style="color: #ff0000;"><?php echo $valid->error('first_name'); ?></div>
      </div>

      <div>
        <label for="lastName" id="lastName">Last Name</label><br>
        <input type="text" name="last_name">
        <div style="color: #ff0000;"><?php echo $valid->error('last_name'); ?></div>
      </div>

      <div>
        <label for="email" id="email">Email</label><br>
        <input type="text" name="email">
        <div style="color: #ff0000;"><?php echo $valid->error('email'); ?></div>
      </div>

      <input type="submit">

    </form>
  </body>
</html>
````

## LAB 1
Copy the path _/var/www/mtbc/exercises/php/forms/spa.php_ to _/var/www/mtbc/labss/php/forms/spa.php_

Modify _/var/www/mtbc/labss/php/forms/spa.php_.
* Add a form field for entering URLs.
* Add a validation method for the URL field.
* Update the email and URL validation method to return true when the input passes validation OR when the field is empty.
* The MUST reject an empty email but allow an empty URL so that the field is not required but will be validated when not empty.

## Additional Reading
* [Email RegEx Examples](http://emailregex.com/)
* [HTML Purifier](http://htmlpurifier.org/)
* [Yahoo's HTML Purify](https://github.com/yahoo/html-purify)
* [Google Caja](https://code.google.com/archive/p/google-caja/wikis/JsHtmlSanitizer.wiki)
* [Sanitize HTML](https://www.npmjs.com/package/sanitize-html)
