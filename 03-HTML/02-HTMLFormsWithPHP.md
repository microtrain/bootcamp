# [HTML Forms](https://www.w3.org/TR/html401/interact/forms.html) with PHP Validation

Traditionally, forms have been the most common way to collect data from a user. A form submission is the simplest way to post data to a server. This section will start with a simple POST request and end with complex processing.

Form tags ````<form></form>```` are used for creating forms in HTML. Every form should have at least two attributes _action_ and _method_.

* action - the web address to which the form data will be sent.
* method - the type of request the form should make (probably GET or POST).

## Exercise 1 - Create and Inspect a Contact Form

Create the following path.
````
/var/www/example.com/contact.php
````

_/var/www/example.com/contact.php_
````
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Contact Me - YOUR-NAME</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>
  <body>
    <h1>Contact YOUR-NAME</h1>
    <form method="post">
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

      <div>
        <label for="subject" id="subject">Subject</label><br>
        <input type="text" name="subject">
      </div>

      <div>
        <label for="message" id="message">Message</label><br>
        <textarea name="message"></textarea>
      </div>

      <input type="submit">

    </form>
  </body>
</html>
````

Now, lets inspect a post request.
* Open the Chrome browser and navigate to [http://localhost/mtbc/exercises/html/forms/form.php](http://localhost/YOUR-PROJECT-NAME/contact.html).
* Press the [f12] key to open Chrome's developer tools.
* Click on the network tab.
* Refresh the page.
* Find and click on contact.php
* The headers tab should now be highlighted.

![Installation type](/img/devtools/devtools.png)

* Fill out the web form and submit the data.
* Once again, find and click on form.html from the network panel.
* Under the headers tab you will see the contents of your web form as key to value pairs. This is how the data will be given to the server.s

![Installation type](/img/devtools/form_data.png)


Find the opening form tag and set the action attribute as follows.
*action="contact.php"*

Add the following to the top of the document, above the DOCTYPE declaration.
````
<?php

$data = $_POST;

foreach($data as $key => $value){
  echo "{$key} = {$value}";
}
?>
````

## Validation and Basic RegEx

Regular Expressions (RegEx) are strings of text that describe a search pattern. You may be familiar with wild cards in which a search for _b*_ would return all words that start with the letter b. Now lets say you want your wild card search to still return all words starting with the letter b but only if the word does not contain a number; this is where RegEx comes in ````\b(b)+([a-z])*\b````.

* ````\b```` - a word boundary, the beginning of a word. This would return all words.
* ````\b(b)*```` - MUST start with the letter b. This would return all words starting with the letter b.
* ````\b(b)+([a-z])*```` - MAY also contain any lower case letters after the first letter.
* ````\b(b)+([a-z])*\b```` - Stops each match at the end of a word

[Try It](https://regex101.com/r/dGXnCZ/3/)

##Exercise 2 - RegEx

_/var/www/example.com/contact.php_
````
<?php
//Create a RegEx pattern to determine the validity of the use submitted email
// - allow up to two strings with dot concatenation any letter, any case any number with _- before the @
// - require @
// - allow up to two strings with dot concatenation any letter, any case any number with - after the at
// - require at least 2 letters and only letters for the domain
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
?>
````

RegEx is extremely powerful, flexible and worth learning. Having said that there are a million and one libraries for validating form submissions. I would advise finding a well supported library that meets your projects needs. As of PHP5 [data filters](http://php.net/manual/en/book.filter.php) have been natively supported by the language.

**Security Check Point**
_Never trust user input. User input is anything come into the server from the client. Even if you have written client side JavaScript to filter out malicious code, the filtered input is still left alone with the client and can be manipulated prior to transit (or even in transit). If it has ever existed outside of the server it CANNOT be trusted._

##Exercise 3 - Adding a Validation Class
Replace the contents of _/var/www/example.com/contact.php_ with the following.

Explain the code to the class.

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

    public function userInput($key){
        return (!empty($this->data[$key])?$this->data[$key]:null);
    }
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

    <form method="post" action="contact.php">

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

      <div>
        <label for="subject" id="subject">Subject</label><br>
        <input type="text" name="subject">
        <div style="color: #ff0000;"><?php echo $valid->error('subject'); ?></div>
      </div>

      <div>
        <label for="message" id="message">Message/label><br>
        <textarea name="message"></textarea>
        <div style="color: #ff0000;"><?php echo $valid->error('message'); ?></div>
      </div>

      <input type="submit">

    </form>
  </body>
</html>
````

## Include Files and Namespaces

So far we have a lot of code in the what would typically be considered a *view* (the presentation layer) which should be separated from from data and logic as much as possible. In this lesson we will create include and class files that will help us keep out views clean.

[PHP Fig](http://www.php-fig.org/) is a working group aimed at developing interoperability standards for PHP libraries. This will help us build a standardized directory structure.
* [PSR 0](http://www.php-fig.org/psr/psr-0/)
* [PSR 4](http://www.php-fig.org/psr/psr-4/)

### Include Files
An include file is a file that contains a snippet of code that is referenced by another file. In PHP include files can be accessed using  [include](http://php.net/manual/en/function.include.php), [include _once](http://php.net/manual/en/function.include_once.php), [require](http://php.net/manual/en/function.require.php) or [require_once](http://php.net/manual/en/function.require_once.php) functions along with a relative or absolute file path.

````
// relative include
include util.php;

// absolute include
include /var/www/example.com/util.php;
````

### Namespace
At the end of the day a name space is simply a way to disambiguate name collisions. Earlier we created a class called Validate(). Validation classes are fairly common and let's say you liked specific methods from two different vendors both of who named the class Validate, suddenly you have a collision.

Lets say we have two vendors Sally and Bob and I like Sally's email method and Bob's phone method. I want to load this class from both vendors but without a name space the autoloader would not know which class to load into a given object. I might try to include then instantiate but there is no guarantee this will work as classes tend to get cached.

````
include 'vendor/Sally/src/Validation/Validate.php';
$v1 = new Validate();
$v1->Validate->email($email); //This will probably work

include 'vendor/Bob/src/Validate/Validate.php';
$v2 = new Validate();
$v2->Validate->phone($phone); //Sally's version of the class may or may not be cached so the method we want may or may not be there.
````

With name spaces.
````
// You can probably use an autoloader so you will not have to worry about this.
include 'vendor/Sally/src/Validation/Validate.php';
include 'vendor/Bob/src/Validate/Validate.php';

// The namespace disambiguates class names so $v2's object will have the target class.
$v1 = new \Sally\Validation\Validate();
$v2 = new \Bob\Validate\Validate();

$v1->Validate->email($email);
$v2->Validate->phone($phone);
````

## Exercise 4
Create the path */var/www/example.com/core/YOUR-PROJECT-NAME/src/Validation/Validate.php* and copy the Validates class into the file. Add a name space declaration as the first line of the file.

````
<?php

namespace About\Validation;

````



## Additional Resources
* [Email RegEx Examples](http://emailregex.com/)
* [RegEx 101](https://regex101.com/)
* [HTML Purifier](http://htmlpurifier.org/)
* [Yahoo's HTML Purify](https://github.com/yahoo/html-purify)
* [Google Caja](https://code.google.com/archive/p/google-caja/wikis/JsHtmlSanitizer.wiki)
* [Sanitize HTML](https://www.npmjs.com/package/sanitize-html)
