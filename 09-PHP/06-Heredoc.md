# Templates

Now that we have all of our styles into a single style sheet, it is time to use a single template for managing our layout. This will allow us to store our site's main layout in a single file while the page itself will only hold the content specific to that page. This is a huge win once your site exceeds more that a few pages. HTML does not offer such a system so we will either need to choose a template engine such as [Pug](https://pugjs.org/api/getting-started.html) or build a template using a programming language. We will learn about Pug once we get into the section about the MEAN stack. For now, we will use PHP.


![TempEngWeb016.svg](https://upload.wikimedia.org/wikipedia/en/a/a2/TempEngWeb016.svg)
[About: TempEngWeb016.svg](https://en.wikipedia.org/wiki/File:TempEngWeb016.svg)


The general flow is as follows.
1. The user asks the server for an endpoint perhaps *https://localhost/example.com/public/contact.php*.
1. The server processes data and business logic as required by that endpoint.
  1. This may include calls from a database, a flat-file, an API, etc.
1. The server generates the content to be presented to the user for that endpoint.
  1. This may be from a database, a flat-file, an API, etc.
1. The server calls the template for that endpoint.
1. The server passes the content into the template.
1. The endpoint presents the data to the user. This may be in the form of an HTML document, a PDF, XML/JSON file or whatever else may be required.

## [Heredoc](http://php.net/manual/en/language.types.string.php#language.types.string.syntax.heredoc)

A ```heredoc``` allows a large amount of text to be written as a string without the needing to escape special characters. Heredoc will process any PHP code it encounters, which makes it a subtitle candidate for our simple use case. I should note this a very simple example of a template system and is intended simply as an introduction to the concept. We will discuss more complex examples in later lessons.

In previous lessons, we used ```echo``` to write the value of some variables into an HTML document. This is a good way to view a template system. This is something that allows you to have a single or a select few templates that treat the contents in which the content of a page is being passed as a variable onto the template.

The basic idea is as follows. We are simply passing the variable ```$content``` into an HTML document using PHP's echo statement.

```php
<?php $content="<h1>Hello World</h1><p>Welcome to my web page.</p>"; ?>

<html>
  <head></head>
  <body><?php echo $content; ?></body>
</html>
```

The previous example works for simple strings, but what about a page that has tens if not hundreds of lines of HTML? Writing all of that as a PHP string is tedious and prone to error, this is where the heredoc syntax can help.
```php
<?php
$who = 'World';
$content = <<<EOT
<h1>Hello {$who}</h1>
<p>Welcome to my web site.</p>
EOT;
?>
<html>
  <head></head>
  <body><?php echo $content; ?></body>
</html>
```

A heredoc string start by declaring a variable and setting a delimiter. PHP uses ```<<<``` to declare a delimiter. In our case ```<<<EOT``` (End of Text) is our delimiter. When a delimiter is encountered followed by a semicolon with no spaces around it the string is terminated.

The previous example passes the content into an HTML string but it still requires the entire document to be embedded in every page. Let's push the HTML document into an include file.

*contact.php*
```php
<?php
$who = 'World';
$content = <<<EOT
<h1>Hello {$who}</h1>
<p>Welcome to my web site.</p>
EOT;

require 'layout.php';
```

*layout.php*
```php
<html>
  <head></head>
  <body><?php echo $content; ?></body>
</html>
```

Now we only have to include the layout on each page of our site. The advantage is we will only need to change a single file to cascade [Look and Feel](https://en.wikipedia.org/wiki/Look_and_feel) changes across the entire website.

## Exercise 1

Create the path */var/www/example.com/core/layout.php* and add the following lines.

```php
<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="UTF-8">
      <title>About Jason Snider</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" type="text/css" href="css/dist/main.css">
  </head>
  <body>

    <div id="Wrapper">
        <nav class="top-nav">
            <a href="index.html" class="pull-left" href="/">Site Logo</a>
            <ul role="navigation">
                <li><a href="index.php">Home</a></li>
                <li><a href="resume.php">Resume</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </nav>

        <div class="row">
            <div id="Content">
                <?php echo $content; ?>
            </div>
            <div id="Sidebar">
              <div id="AboutMe">
                <div class="header">Hello, I am YOUR-NAME</div>
                <img src="https://www.gravatar.com/avatar/4678a33bf44c38e54a58745033b4d5c6?d=mm" alt="My Avatar" class="img-circle">
              </div>
            </div>
        </div>

        <div id="Footer" class="clearfix">
            <small>&copy; 2017 - MyAwesomeSite.com</small>
            <ul role="navigation">
                <li><a href="terms.html">Terms</a></li>
                <li><a href="privacy.html">Privacy</a></li>
            </ul>
        </div>
    </div>

  </body>

</html>

```

Copy, Rename and Change the path */var/www/example.com/public/contact.php* to the following *core/processContactForm.php* Pay special attention to the echo statements, these are now treated as variables being passed into a string such that ```<?php echo $valid->userInput('first_name'); ?>``` becomes ```{$valid->userInput('first_name')}```.

*public/contact.php
```php
<?php

require 'core/processContactForm.php';

$content = <<<EOT
<form method="post" action="contact.php">
  {$message}
  <div>
    <label for="firstName">First Name</label><br>
    <input type="text" name="first_name" id="firstName" value="{$valid->userInput('first_name')}">
    <div class="text-error">{$valid->error('first_name')}</div>
  </div>

  <div>
    <label for="lastName" id="lastName">Last Name</label><br>
    <input type="text" name="last_name" value="{$valid->userInput('last_name')}">
    <div class="text-error">{$valid->error('last_name')}</div>
  </div>

  <div>
    <label for="email" id="email">Email</label><br>
    <input type="text" name="email" value="{$valid->userInput('email')}">
    <div class="text-error">{$valid->error('email')}</div>
  </div>

  <div>
    <label for="subject" id="subject">Subject</label><br>
    <input type="text" name="subject" value="{$valid->userInput('subject')}">
    <div class="text-error">{$valid->error('subject')}</div>
  </div>

  <div>
    <label for="message" id="message">Message</label><br>
    <textarea name="message">{$valid->userInput('message')}</textarea>
    <div class="text-error">{$valid->error('message')}</div>
  </div>


  <input type="submit">

</form>
EOT;

require '../core/layout.php';
```
*core/processContactForm.php
```
<?php
require '../core/About/src/Validation/Validate.php';
include '../vendor/autoload.php';
require '../config/keys.php';
use Mailgun\Mailgun;
use About\Validation;

$valid = new About\Validation\Validate();

$filters = [
    'name'=>FILTER_SANITIZE_STRING,
    'email'=>FILTER_SANITIZE_EMAIL,
    'message'=>FILTER_SANITIZE_STRING,
];
$input = filter_input_array(INPUT_POST, $filters);

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

# Instantiate the client.
$mgClient = Mailgun::create(MG_KEY,MG_API); //MailGun key 
$domain = MG_DOMAIN; //API Hostname
$from = "Mailgun Sandbox <postmaster@{$domain}>";

# Make the call to the client.
$result = $mgClient->messages()->send($domain,
array   (  
          'from'    => "{$input['name']} <{$input['email']}>",      
          'to'      => 'Your Name <name@your-email.com>',
          'subject' => 'Hello Your-Name',
          'text'    => $input['message']
        )
    );   
/* Use To Show Input When Needed
var_dump($result);
*/

    $message = "<div class=\"message-success\">Your form has been submitted!</div>";
    }else{
        $message = "<div class=\"message-error\">Your form has errors!</div>";
    }
}
```

Navigate to *https://loc.example.com/public/contact.php* and submit the form. The functionality should not have changed in any way but the code is now cleaner and easier to maintain this is known as a [refactoring](https://martinfowler.com/books/refactoring.html).


## Additional Resources

* [Web template system](https://en.wikipedia.org/wiki/Web_template_system)
* [Output Buffering Control](http://php.net/manual/en/book.outcontrol.php)

[Next: Meta Data](07-Metadata.md)
