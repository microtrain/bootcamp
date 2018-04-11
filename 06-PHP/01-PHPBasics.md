# PHP Basics

PHP (the P in LAMP stack) is a popular server side scripting language. Once you have a LAMP server up an running, getting started with PHP is pretty easy.

Since this is a dev environment we want to able to debug errors. Lets tell Apache to show us errors when accessing PHP files.

```sh
sudo vim /etc/php/7.0/apache2/php.ini
```

Find the _display_errors_ directive by typing _\display_errors =_ in vim. This will be around line 426 enter insert mode and change *display_errors = Off* to *display_errors = On* then restart Apache.

>**Security Check Point**  
>It is never advisable to show errors in a productions environment. This provides information to hackers that can be used to compromise your system.

## Hello World

Since you can mix PHP and HTML in the same file the parser will need a way to know if it is being asked to parse PHP or HTML. We tell the parser what to expect by using PHP tags ```<?php ?>``` where ```<?php``` in the opening tag and ```?>``` is the closing tag. Any text outside of the  

## Exercise 1 - Hello World
Create the path _/var/www/mtbc/php_ and that as a project to Atom's side bar. Then from Atom create the file *hello.php*. Add the following lines.

```php
<?php
/**
 * Greets the user with the current date and time.
 */

//Create a date object http://php.net/manual/en/book.datetime.php from PHP's built
$date = new DateTime();

#Format the date http://php.net/manual/en/datetime.formats.date.php
$formattedDate = $date->format('Y-m-d h:i:s');

echo "Hello World it is {$formattedDate}";
```

Open a browser and navigate to *https://localhost/php/hello.php*. You will see the string _Hello it is x_ where x is the current date and time.

Now lets have another look at what we wrote, don't worry if you do not get this, we will go over it all again when we dive into the programming lessons.

The first line is ```<?php```, this tells the server to begin interpreting PHP. PHP tags open with ```<?php``` and close with ```?>``` if there is no closing tag it is assumed all text after the opening PHP tag is to interpreted as PHP.

Line 2 is a comment there are three types of comments in PHP.
* ```# This is a comment```
* ```// This is a comment ```  
* ```/* this is a comment */```

Line 4 creates an object<sup>1</sup>, in the case the object is an instance of the date class ```$date = new DateTime();```

* ```$date``` - this is a variable that will hold an instance of the DateTime() class (_$date_ holds the instantiated object)
* ```new``` - says I want to create a new copy (instantiation) of a class.
* ```DateTime()``` - the class to be instantiated. The parenthesis indicate an empty constructor<sup>2</sup>.

Line 7 stores the result of an operation in a variable called ```$formattedDate```.

A method is a property of an object in PHP we can access a propery of an object using an arrow ```->```. ```format()``` is a method (a type of property) of the ```DateTime()``` class. Here the operation is simply formatting the current Unix timestamp to a human readable format. ```$date->format('Y-m-d h:i:s')``` says I want to call the _format()_ method of the _$date_ object with the following parameters ```'Y-m-d h:i:s'```.

* ```$formattedDate``` - A variable that holds a formatted date string.
* ```=``` - Sets the value of the left to that of the right.
* ```$date``` - The instantiated date object.
* ```->``` - Object operator, this is used to request properties from an instantiated object. In most languages use dot concatenation ``` . ```.
* ```format()``` - A method of the DateTime() class, a property of the instantiated
object.
* ```'Y-m-d h:i:s'``` - A parameter for the format method. In this case we are providing a string representation of what we want the formatted date to look like.

In the final line we are printing results to the screen.

* ```echo``` - Tells PHP to write something to a web page.
* ```""``` - Defines the string to be written, everything inside the quotes will
be printed.
* ```$formattedDate``` - The formatted date string.
* ```{}``` - Not required, but makes it easier to separate variables from strings.


## PHP Classes

Object Oriented Programming (OOP) has been supported by PHP (at least in some fashion) since version 4. OOP support has improved with each version. Generally speaking a class is blue print for an object. If we were to compare this to the physical world the source code contained in the class would be akin to an architects blue prints say for a house. Upon instantiation the class is used to build the object. In short, you could view a house as an instantiation of a set of blue prints. I give the blue prints to the builder (in this case a compiler) and the builder goes of and does its thing. The end result is that builders interpretation of the blue prints.

A class has properties comprised of instance variables, methods. A class may be dependent on other classes, this is known as a dependency and is often dealt with using dependency injection. A class may inherit from other classes this is known as either a parent class to a child class or super class to sub class.

The classic example of a class and class properties is to think of a person. A person class would have properties such as a head, arms, legs, etc. I prefer to think in terms of completing work as this is really what we want our classes to do. For example if I were to have a class for reading and writing to and from the database I might call it DBWorker. Now the question is what do I need DBWorker to do?

I'll need my DBWorker class to

* connect to the database
* know which table to access
* write new records to the database
* read records in from the database
* update records in the database
* delete records from the database

So far my properties would be as follows

* Instance Variable - *table*
* Method - *connect()*
* Method - *create()*
* Method - *read()*
* Method - *update()*
* Method - *delete()*

In PHP this might look like the following
```php
class DBWorker
{
    private $table = null;

    public function __construct($connection, $table) {
      $this->connect($connection);
      $this->$table = $table;
    }

    private function connect($connection){//do something}

    public function create($data) {//do something}

    public function read($whereClause) {//do something}

    public function update($data, $whereClause) {//do something}

    public function delete($whereClause) {//do something}

}

```

Instantiation may look like this
```php
// This would probably be in a config file somewhere.
$config = [];
$config['db'] = '{'db':sample_db', 'user':'sample_user', 'password':'123456', 'host':'localhost'}';

// Instantiate DBWorker with a given db configuration.
$dbw = new DBWorker($config['db'], 'People');

// Read from the database with given parameters.
$results = $dbw->read('{'email':'%@example.com'}');

//Process the results
foreach($results as $result){
  //do something
}

```

### Exercise 2 - Hello Class
Create the path */var/www/mtbc/php/hello_class.php*.

```php
<?php

/**
 * A mock up of session data
 */
class Session
{
  /**
   * Returns the current user session
   * @return array Session Data
   */
  public function read()
  {
    return ['id'=>'1234', 'name'=>'YOUR-NAME'];
  }
}

/**
 * Returns a greeting to a given user
 */
class Hello
{
  /**
   * An instance variable to hold the name of the user
   * @var string
   */
  private $who;

  /**
   * A constructor method - Constructor injection with type hinting. Constructor injection is a form of type hinting.
   * @param  Object $session A user session
   */
  public function __construct(Session $session) {

    $sessionData = $session->read();

    $this->setWho($sessionData['name']);
  }

  /**
   * A setter method for Hello::who
   * @param String $who - The name of a given user
   */
  public function setWho($who)
  {
    $this->who = $who;
  }

  /**
   * Returns a greeting to a target user
   * @param  {[type]} $message [description]
   * @return {[type]}          [description]
   */
  public function greet($message)
  {
    return "{$message} {$this->who}";
  }

}

//Instantiate the Session class
$session = new Session();

//Instantiate the Hello class. Inject the $session object into the constructor.
$greeting = new Hello($session);

//Provide a message for the user (Ternary Logic)
$message = 'Good ' . (date("H")<12?'Morning':(date("H")<17?'Afternoon':'Evening'));

echo $greeting->greet($message);
```

### Exercise 3 - example.com

Start by making a copy of your GitHub pages project

```sh
cd /var/www
mkdir -p example.com/public
cp /var/www/YOUR-GITHUB-USERNAME /var/www/example.com
```

Move src, dist and all html files into the public directory. 

## Additional Resources
* [Object Oriented PHP for Beginners](https://www.killerphp.com/tutorials/object-oriented-php/)
* [PHP Shorthand If/Else Using Ternary Operators (?:)](https://davidwalsh.name/php-shorthand-if-else-ternary-operators)
* [Dependency Injection in PHP](https://codeinphp.github.io/post/dependency-injection-in-php/)

## Footnotes
<sup>1</sup> PHP supports both procedural (functional) programming and object oriented programming (OOP). In OOP an instantiated class is an object. A class could be considered a blue print for an object. PHP has a built in class for working with dates called _DateTime_. PHP instantiates classes with the ```new``` operator. The line ```$date = new DateTime();``` stores an instance of the _ DateTime_ object in a variable called _$date_. PHP uses an arrow  ```->``` as it's [Object Operator](https://stackoverflow.com/questions/2588149/what-is-the-php-operator-called-and-how-do-you-say-it-when-reading-code-out). To access the _format_ method of the _DateTime_ class you would say ```$date->format();```. In this case we are storing the formatted date in the variable _formattedDate_. As in Bash, PHP uses _echo_ to write content to the screen. In this case, a web page.

<sup>2</sup> An empty constructor, constructor with no argument. In programming arguments allow us to pass data into objects, methods and functions.

[Next: PHP Control Structures](04-PHPControlStructures.md)
