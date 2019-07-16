# PHP Basics

PHP (the P in LAMP stack) is a popular server side scripting language. Once you have a LAMP server up an running, getting started with PHP is pretty easy.

Since this is a dev environment we want to able to debug errors. Lets tell Apache to show us errors when accessing PHP files.

```sh
sudo vim /etc/php/7.2/apache2/php.ini
```

Find the _display_errors_ directive by typing _\display_errors =_ in vim. This will be around line 426 enter insert mode and change *display_errors = Off* to *display_errors = On* then restart Apache.

```sh
sudo service apache2 reload
```

>**Security Check Point**  
>It is never advisable to show errors in a productions environment. This provides information to hackers that can be used to compromise your system.

## Hello World

Since you can mix PHP and HTML in the same file the parser will need a way to know if it is being asked to parse PHP or HTML. We tell the parser what to expect by using PHP tags ```<?php ?>``` where ```<?php``` in the opening tag and ```?>``` is the closing tag. Any text outside of the  

## Exercise 1 - Hello World
Create the path _/var/www/mtbc/php_ and that as a project to the VSC explorer. Then from your IDE create the file *hello.php*. Add the following lines.

```php
<?php

//Great the user with a hello message
echo "Hello World";
```

```php
<!DOCTYPE html>
<html lang="en">
    <head>
      <meta charset="UTF-8">
      <title>Contact</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
       <h1><?php echo 'Hello World'; ?></h1>
    </body>
</html>
```

```php
<?php
  $msg = 'Hello World';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
      <meta charset="UTF-8">
      <title>Contact</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
       <h1><?php echo $msg; ?></h1>
    </body>
</html>
```

```php
<?php
  //Literal string, no processing
  $name = 'Bob Smith';
  //Varaible string, allows processing
  $msg = "Hello {$name}";
  //The following would work as above
  //$msg = "Hello $name";
  //The following is an example of contactination
  //$msg = 'Hello ' . $name;
?>
<!DOCTYPE html>
<html lang="en">
    <head>
      <meta charset="UTF-8">
      <title>Contact</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
       <h1><?php echo $msg; ?></h1>
    </body>
</html>
```

```php
<?php
  $name = 'Bob Smith';
  $greeting = "Hello {$name}";
  $count=5;
  $price=3.00;
  //Note the escape character before the dollar sign
  $msg = "I see you have {$count} oranges, that will be \${$price]}";

?>
<!DOCTYPE html>
<html lang="en">
    <head>
      <meta charset="UTF-8">
      <title>Contact</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
       <h1><?php echo $greeting; ?></h1>
       <p><?php echo $msg;?></p>
    </body>
</html>
```

Mathematical operations
```php
<?php
  $name = 'Bob Smith';
  $greeting = "Hello {$name}";
  $count=5;
  $price=.6;
  $total=($count*$price);
  $msg = "I see you have {$count} oranges, that will be \${$total}";

?>
<!DOCTYPE html>
<html lang="en">
    <head>
      <meta charset="UTF-8">
      <title>Contact</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
       <h1><?php echo $greeting; ?></h1>
       <p><?php echo $msg;?></p>
    </body>
</html>
```

## Additional Resources

[Next: PHP Control Structures](02-PHPControlStructures.md)
