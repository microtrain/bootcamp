# [HTML Forms](https://www.w3.org/TR/html401/interact/forms.html) with PHP Validation

Forms are one of the most common ways to collect data from a user. Submitting a 
form is one of the simplest ways to post data to a server. This lesson will 
start with a simple POST request and end with complex processing.

The ```form``` element ```<form></form>``` is used for creating forms in HTML. 
Every ```form``` should have at least two attributes ```action``` and 
```method```.

* ```action``` - the web address to which the form data will be sent.
* ```method``` - the type of request the form should make (probably GET or 
POST).

## Exercise 1 - Create and Inspect a Contact Form

Rename *public/contact.html* to *public/contact.php*  and complete the following three steps.

**1. Change the action to contact.php**
```html
<form action="contact.php" method="POST">
```

**2. Remove the lines**
```html
<input type="hidden" name="_next" value="https://YOUR-GITHUB-USERNAME.github.io/thanks.html">
<input type="text" name="_gotcha" style="display:none">
```

**3. Change _subject to subject and _replyTo to email**
```html
<input type="hidden" name="_subject" value="New submission!">
...
<input id="email" type="text" name="_replyto">  
```

The end result will be as follows
```html
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Contact Me - YOUR-NAME</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./dist/css/main.css" type="text/css">
  </head>
  <body>
    <header>
      <span class="logo">My Website</span>
      <a id="toggleMenu">Menu</a>
      <nav>
        <ul>
          <li><a href="index.html">Home</a></li>
          <li><a href="resume.html">Resume</a></li>
          <li><a href="contact.html">Contact</a></li>
        </ul>
      </nav>
    </header>
    <main>

      <h1>Contact Me - YOUR-NAME</h1>
      <form action="contact.php" method="POST">
        
        <input type="hidden" name="subject" value="New submission!">
        
        <div>
          <label for="name">Name</label>
          <input id="name" type="text" name="name">
        </div>

        <div>
          <label for="email">Email</label>
          <input id="email" type="text" name="email">  
        </div>

        <div>
          <label for="message">Message</label>
          <textarea id="message" name="message"></textarea>
        </div>

        <div>
          <input type="submit" value="Send">
        </div>

      </form>
      
    </main>
    <script>
        var toggleMenu = document.getElementById('toggleMenu');
        var nav = document.querySelector('nav');
        toggleMenu.addEventListener(
          'click',
          function(){
            if(nav.style.display=='block'){
              nav.style.display='none';
            }else{
              nav.style.display='block';
            }
          }
        );
      </script>
  </body>
</html>
```

Now, lets inspect a post request.
* Open the Chrome browser and navigate to [http://localhost.example.com/public/contact.php](http://localhost.example.com/public/contact.php).
* Press the [f12] key to open Chrome's developer tools.
* Click on the Network tab.
* Refresh the page.
* Find and click on contact.php
* The headers tab should now be highlighted.

![Installation type](/img/devtools/devtools.png)

* Fill out the webform and submit the data.
* Once again, find and click on contact.php from the network panel.
* Under the headers tab, you will see the contents of your webform as key-to value-pairs. This is how the data will be given to the server.

![Installation type](/img/devtools/form_data.png)


Find the opening form tag and set the action attribute as follows.
*action="contact.php"*

Add the following to the top of the document, above the DOCTYPE declaration.
```php
<?php

$data = $_POST;

foreach($data as $key => $value){
  echo "{$key} = {$value}";
}
?>
```

## Validation and Basic RegEx

Regular Expressions (RegEx) are strings of text that describe a search pattern. You may be familiar with wild cards in which a search for _b*_ would return all words that start with the letter b. Now lets say you want your wild card search to still return all words starting with the letter b but only if the word does not contain a number; this is where RegEx comes in ```\b(b)+([a-z])*\b```.

* ```\b``` - a word boundary, the beginning of a word. This would return all words.
* ```\b(b)*``` - MUST start with the letter b. This would return all words starting with the letter b.
* ```\b(b)+([a-z])*``` - MAY also contain any lower case letters after the first letter.
* ```\b(b)+([a-z])*\b``` - Stops each match at the end of a word

[Try It](https://regex101.com/r/dGXnCZ/3/)

## Exercise 2 - RegEx

*/var/www/example.com/public/contact.php*
```php
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
```

RegEx is extremely powerful, flexible and worth learning. Having said that there are a million and one libraries for validating form submissions. I would advise finding a well-supported library that meets the needs of your project. As of PHP5 [data filters](http://php.net/manual/en/book.filter.php) have been natively supported by the language.

**Security Check Point**
_Never trust user input. User input is anything that comes into the server from the client. Even if you have written client-side JavaScript to filter out malicious code, the filtered input is still left alone with the client and can be manipulated before transit (or even in transit). If it has ever existed outside of the server it CANNOT be trusted._

## Exercise 3 - Adding a Validation Class
Replace the contents of _/var/www/example.com/public/contact.php_ with the following.

Explain the code to the class.

1. The user completes and submits a web form.
1. The system
    1. Validates each field for errors.
        1. If an error occurs, return a message to the user
            1. Show a page-level message.
            1. Show each field-level message.
            1. Do not clear the form data if an error occurs.
        1. If no errors, send the user to a thank you page.

2.1 - Loop through each form field and test that field for errors.

2.2 - Set a truthy/falsy value or a boolean on error. This will tell the system how to proceed after the form is processed.

2.2.1 - See 2.2

2.2.2 - Store each error in an array using the name of the field as the array key. The value will be the error message to display to the user. The form will call a method in the validate array using the name of the field as the argument. This will retrieve any error messages for that field.

2.2.3 - Store POST data in an instance variable using key-value pairs in which the key is the name of the form field and value is the user-submitted data. Set the value attribute of each form field to a method in the Validate class and pass the name of the field as the method's argument. This will retrieve the original data as submitted by the user and pre-populate that form field.

```php
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

$valid = new Validate();

$args = [
  'name'=>FILTER_SANITIZE_STRING,
  'subject'=>FILTER_SANITIZE_STRING,
  'message'=>FILTER_SANITIZE_STRING,
  'email'=>FILTER_SANITIZE_EMAIL,
];

$input = filter_input_array(INPUT_POST, $args);

if(!empty($input)){

    $valid->validation = [
        'email'=>[[
                'rule'=>'email',
                'message'=>'Please enter a valid email'
            ],[
                'rule'=>'notEmpty',
                'message'=>'Please enter an email'
        ]],
        'name'=>[[
            'rule'=>'notEmpty',
            'message'=>'Please enter your first name'
        ]],
        'message'=>[[
            'rule'=>'notEmpty',
            'message'=>'Please add a message'
        ]],
    ];

    $valid->check($input);

    if(empty($valid->errors)){
        $message = "<div class=\"message-success\">Your form has been submitted!</div>";
        //header('Location: thanks.php');
    }else{
        $message = "<div class=\"message-error\">Your form has errors!</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Contact Me - YOUR-NAME</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./dist/css/main.css" type="text/css">
  </head>
  <body>
  
    <header>
      <span class="logo">My Website</span>
      <a id="toggleMenu">Menu</a>
      <nav>
        <ul>
          <li><a href="index.html">Home</a></li>
          <li><a href="resume.html">Resume</a></li>
          <li><a href="contact.html">Contact</a></li>
        </ul>
      </nav>
    </header>
    
    <main>
      <h1>Contact Me - YOUR-NAME</h1>

      <?php echo (!empty($message)?$message:null); ?>

      <form action="contact.php" method="POST">
        
        <input type="hidden" name="subject" value="New submission!">
        
        <div>
          <label for="name">Name</label>
          <input id="name" type="text" name="name" value="<?php echo $valid->userInput('name'); ?>">
          <div class="text-error"><?php echo $valid->error('name'); ?></div>
        </div>

        <div>
          <label for="email">Email</label>
          <input id="email" type="text" name="email" value="<?php echo $valid->userInput('email'); ?>">
          <div class="text-error"><?php echo $valid->error('email'); ?></div>
        </div>

        <div>
          <label for="message">Message</label>
          <textarea id="message" name="message"><?php echo $valid->userInput('message'); ?></textarea>
          <div class="text-error"><?php echo $valid->error('message'); ?></div>
        </div>

        <div>
          <input type="submit" value="Send">
        </div>

      </form>
    </main>
    
    <script>
        var toggleMenu = document.getElementById('toggleMenu');
        var nav = document.querySelector('nav');
        toggleMenu.addEventListener(
          'click',
          function(){
            if(nav.style.display=='block'){
              nav.style.display='none';
            }else{
              nav.style.display='block';
            }
          }
        );
      </script>
  </body>
</html>
```

## Include Files and Namespaces

So far we have a lot of code in the what would typically be considered a *view* (the presentation layer) which should be separated from from data and logic as much as possible. In this lesson we will create include and class files that will help us keep out views clean.

[PHP Fig](http://www.php-fig.org/) is a working group aimed at developing interoperability standards for PHP libraries. This will help us build a standardized directory structure.
* [PSR 0](http://www.php-fig.org/psr/psr-0/)
* [PSR 4](http://www.php-fig.org/psr/psr-4/)

### Include Files
An include file is a file that contains a snippet of code that is referenced by another file. In PHP include files can be accessed using  [include](http://php.net/manual/en/function.include.php), [include _once](http://php.net/manual/en/function.include_once.php), [require](http://php.net/manual/en/function.require.php) or [require_once](http://php.net/manual/en/function.require_once.php) functions along with a relative or absolute file path.

```php
// relative include
include 'util.php';

// absolute include
include '/var/www/example.com/util.php';
```

### Namespace
At the end of the day, a namespace is a way to disambiguate name collisions. Earlier we created a class called Validate(). Validation classes are fairly common and let's say you liked specific methods from two different vendors both of who named the class Validate, suddenly you have a collision.

Let's say we have two vendors Sally and Bob and I like Sally's email method and Bob's phone method. I want to load this class from both vendors but without a namespace, the autoloader would not know which class to load into a given object. I might try to include then instantiate but there is no guarantee this will work as classes tend to get cached.

```php
include 'vendor/Sally/src/Validation/Validate.php';
$v1 = new Validate();
$v1->Validate->email($email); //This will probably work

include 'vendor/Bob/src/Validate/Validate.php';
$v2 = new Validate();
$v2->Validate->phone($phone); //Sally's version of the class may or may not be cached so the method we want may or may not be there.
```

With namespaces.
```php
// You can probably use an autoloader so you will not have to worry about this.
include 'vendor/Sally/src/Validation/Validate.php';
include 'vendor/Bob/src/Validate/Validate.php';

// The namespace disambiguates class names so $v2's object will have the target class.
$v1 = new \Sally\Validation\Validate();
$v2 = new \Bob\Validate\Validate();

$v1->Validate->email($email);
$v2->Validate->phone($phone);
```

## Exercise 4
Create the path */var/www/example.com/core/About/src/Validation/Validate.php* and copy the Validates class into the file. Add a name space declaration as the first line of the file.

*/var/www/example.com/core/About/src/Validation/Validate.php*
```php
<?php

namespace About\Validation;

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

    /**
     * Detects and returns an error message for a given field
     * @param  string $field
     * @return mixed
     */
    public function error($field){
        if(!empty($this->errors[$field])){
            return $this->errors[$field]['message'];
        }

        return false;
    }

    /**
     * Returns the user-submitted value for a give key
     * @param  string $key
     * @return string
     */
    public function userInput($key){
        return (!empty($this->data[$key])?$this->data[$key]:null);
    }
}
```

Since we have pulled the validation logic into a library all we need to do in the contact form is call the class and process it.
*/var/www/example.com/public/contact.php*
```php
<?php
//Include non-vendor files
require '../core/About/src/Validation/Validate.php';

//Declare Namespaces
use About\Validation;

//Validate Declarations
$valid = new About\Validation\Validate();
$args = [
  'first_name'=>FILTER_SANITIZE_STRING,
  'last_name'=>FILTER_SANITIZE_STRING,
  'subject'=>FILTER_SANITIZE_STRING,
  'message'=>FILTER_SANITIZE_STRING,
  'email'=>FILTER_SANITIZE_EMAIL,
];
$input = filter_input_array(INPUT_POST, $args);

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
        'subject'=>[[
            'rule'=>'notEmpty',
            'message'=>'Please enter a subject'
        ]],
        'message'=>[[
            'rule'=>'notEmpty',
            'message'=>'Please add a message'
        ]],
    ];


    $valid->check($input);
}

if(empty($valid->errors) && !empty($input)){
    $message = "<div>Success!</div>";
}else{
    $message = "<div>Error!</div>";
}

?>

<!DOCTYPE html>
```
## Additional Resources
* [PSR-0: Autoloading Standard](http://www.php-fig.org/psr/psr-0/)
* [PHP filter_input_array()](http://php.net/manual/en/function.filter-var.php)
* [PHP filter_var()](http://php.net/manual/en/function.filter-input-array.php)
* [Email RegEx Examples](http://emailregex.com/)
* [RegEx 101](https://regex101.com/)
* [HTML Purifier](http://htmlpurifier.org/)
* [Yahoo's HTML Purify](https://github.com/yahoo/html-purify)
* [Google Caja](https://code.google.com/archive/p/google-caja/wikis/JsHtmlSanitizer.wiki)
* [Sanitize HTML](https://www.npmjs.com/package/sanitize-html)

[Next: Working with APIs](05-MailgunAPI.md)
