# Authentication with MySQL and PHP

This section will cover the basics of sessions, user authentication, and registration.

Simply stated, sessions provide a way to maintain state between a client and a server. A typical session has an id and expiration timestamp. A server will create a session with an id, the server will then send a cookie to the client. This cookie will have a session id. This id is how a given client is able to maintain a unique state with a given server. In the context of authentication, anytime a client makes a request to a server it sends the cookie along with the request, the server reads the id from its session store. If the server can match the id provided by the cookie to a record in the session store and that cookie has not expired then the user is considered to have been authenticated under an active session. The actual authentication would have occurred during a login in which a user would have provided credentials; typically a username and password to the server. Upon the server verifying these credentials, a session record would be stored server-side and a cookie would be sent to the browser. Sessions and cookies may both store additional data depending on the needs of the session and or cookie. By default, PHP stores sessions in a flat-file on the server the originated the session. This can be configured to use any data store either on the origination server or against a central data store. While classic databases such as Oracle, MySQL and MongoDB are not uncommon, in-memory databases such as Redis are gaining popularity.

## Working with Sessions

PHP provides a ```$_SESSION``` superglobal. You may access this superglobal directly or through an abstraction layer. PHP also provides a [SessionHandlerInterface](https://www.php.net/manual/en/class.sessionhandlerinterface.php) for more complicated configurations. While working directly with a superglobal tends to be discouraged we will do it here because I want to focus on the functionality.


*/var/www/example.com/core/session.php*
```php
<?php
//Any page that  works with session data MUST include session_start()
session_start();

//Redirects a user to a login page if there is no active session
function checkSession(){

  $goto='/';
  $hasSession=false;
  if(!empty($_SESSION['user']['id'])){
    $hasSession=true;
  }

  if($hasSession===false){
    //Pass the end point the user is trying to access to the login page
    //This will allow the user to be properly redirected on login
    $goto = $_SERVER['PHP_SELF'];
    $qs = !empty($_SERVER['QUERY_STRING'])?"?{$_SERVER['QUERY_STRING']}":false;
    header('Location: /login.php?goto='.$goto.$qs);
  }

}
```

Add the following to every page on the website. The key is the first line ```session_start()```. Call this on every page to assure the state is not lost.
```php
require '../core/session.php';
```

Add the following to every page that would require authentication. This would force the user back to the home page anytime ```$_SESSION['user']['id']``` equates to empty.

```php
checkSession();
```

### Login (Mock-Up)
We will add some proof of concept code to help us better understand how the session works. This is will create a valid user session without performing the normal authentication logic. This is concept is often referred to as a mock-up.

*public/login.php*
```php
<?php
// 1. Require your session file, this contains session_start()
require '../core/session.php';


// 2. Listen for a POST request. On Post set a session. 
// In the next iteration we replace this with authentication logic.
$_POST['id']=12345;//Force a valid POST
if(!empty($_POST)){
    $_SESSION['user'] = [];
    $_SESSION['user']['id']=$_POST['id'];
    header('LOCATION: ' . $_GET['goto']);
}

// 3. Provide just enough of a form to initiate a POST
$content=<<<EOT
<form method="post">
    <input name="goto" value="{$_GET['goto']}">
    <input type="submit" class="btn btn-primary">
</form>
EOT;

require '../core/layout.php';
```

Add login, logout and register links to your layout (We will create register.php later in the lesson).
*core/layout.php*
```html
<li class="nav-item">
    <a class="nav-link" href="/logout.php">Logout</a>
</li>

<li class="nav-item">
    <a class="nav-link" href="/login.php">Login</a>
</li>

<li class="nav-item">
    <a class="nav-link" href="/register.php">Register</a>
</li>
```

### Logout

There is not much to a logout. We will blank out the session array then call ```session_destroy()```. The user will be redirected to the home page. Either of the aforementioned tactics would work with the above check session method. You may also choose to only blank out the user array ```$_SESSION['user']``` this would allow you to have addition session keys in parallel that would continue to work regardless of state.

*public/logout.php*
```php
<?php
require '../core/session.php';

//Write an empty array to the session
$_SESSION=[];

//Destroy the session file for this session
session_destroy();

header('LOCATION: /');
```

#### Try It Out
Try to see session data in F12 >>Application by clicking on the users link and you will be redirected to the login page. Clicking the submit button initiate a POST request and populate ```$_SESSION['user']['id']```. The *goto* parameter will be appended to the LOCATION header and you will be redirected to the users page. Having an active session you will now have access to every file calling ```checkSession()```. At ant point, clicking the Logout link will end the session and deny you further access to the restricted areas.

## Authentication

Now that we can create a session we will need to provide a means of user authentication. We will do this by adding a hash to our users table and creating a user authentication page. 

Open a MySQL CLI and log into the database.
```sh
mysql -u root -p
```

Switch to the bootcamp database and run the following queries.
```sql
USE bootcamp;
ALTER TABLE users ADD COLUMN hash CHAR(60) AFTER email;
DESCRIBE users;
```

Create the file */public/register.php*

We will start by requiring some files.

*/public/register.php*
```php
<?php
require '../core/session.php';
require '../core/db_connect.php';

$meta=[];
$content='';

require '../core/layout.php';
```

Now we can create a basic contact form, using heredoc syntax, containing the following fields:
  * first_name
  * last_name
  * email
  * password
  * confirm_password 

*/public/register.php*
```php
<?php
require '../core/session.php';
require '../core/db_connect.php';

$meta=[];

$content=<<<EOT
<h1>{$meta['title']}</h1>
<form method="post">

    <div class="form-group">
        <label for="email">Email</label>
        <input 
            class="form-control" 
            id="email" 
            name="email" 
            type="email"
        >
    </div>

    <div class="form-group">
        <label for="first_name">First Name</label>
        <input 
            class="form-control" 
            id="first_name" 
            name="first_name" 
        >
    </div>


    <div class="form-group">
        <label for="last_name">Last Name</label>
        <input 
            class="form-control" 
            id="last_name" 
            name="last_name" 
        >
    </div>

    <div class="form-group">
        <label for="password">Password</label>
        <input 
            class="form-control" 
            id="password" 
            name="password" 
            type="password"
        >
    </div>

    <div class="form-group">
        <label for="confirm_password">Password</label>
        <input 
            class="form-control" 
            id="password" 
            name="confirm_password" 
            type="confirm_password"
        >
    </div>

    <input type="submit" class="btn btn-primary">

</form>
EOT;
require '../core/layout.php';
```

Once the form has been created we can filter the form fields and process the form. We will start by adding input filters and use a simple ```var_dump()``` to verify all the inputs (aka, POST parameters) are getting passed. 

*/public/register.php*
```php
<?php
require '../core/session.php';
require '../core/db_connect.php';

$input = filter_input_array(INPUT_POST,[
    'first_name'=>FILTER_SANITIZE_STRING,
    'last_name'=>FILTER_SANITIZE_STRING,
    'email'=>FILTER_SANITIZE_EMAIL,
    'password'=>FILTER_UNSAFE_RAW,
    'confirm_password'=>FILTER_UNSAFE_RAW,
]);

if(!empty($input)){
  //Start with a var_dump() to verify the inputs
  var_dump($input);
}

$meta=[];
$meta['title']="Register";
/* For brevity we will omit the heredoc, you should not... */
```

Next we will hash and ```var_dump()``` the password field. Then we will add create an insert statement to create the user record.
*/public/register.php*
```php
<?php
require '../core/session.php';
require '../core/db_connect.php';

$input = filter_input_array(INPUT_POST,[
    'first_name'=>FILTER_SANITIZE_STRING,
    'last_name'=>FILTER_SANITIZE_STRING,
    'email'=>FILTER_SANITIZE_EMAIL,
    'password'=>FILTER_UNSAFE_RAW,
    'confirm_password'=>FILTER_UNSAFE_RAW,
]);

if(!empty($input)){
    // 1. Hash the user password
    $hash = password_hash($input['password'], PASSWORD_DEFAULT); 
    //var_dump($hash);

    // 2. Create and execute an INSERT statement
    $sql='INSERT INTO 
        users 
    SET 
        id=UUID(),
        email=:email,
        first_name=:first_name,
        last_name=:last_name,
        hash=:hash
    ';

    $stmt=$pdo->prepare($sql);

    if($stmt->execute([
        'email'=>$input['email'],
        'first_name'=>$input['first_name'],
        'last_name'=>$input['last_name'],
        'hash'=>$hash
    ])){
        //3. On success redirect the user to the login page
        header('LOCATION: /login.php');
    }

}

$meta=[];
$meta['title']="Register";
/* For brevity we will omit the heredoc, you should not... */
```

## Extend Validation

Add validation methods to test password strength and compare ```password``` to ```compare_password```. 

*core/About/src/Validation/Validate.php*

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

    // 1. Password strength - functions by incrementing a local var each time a 
    // requirement is met. Validation passes if a set number of requirements are 
    // met
    public function strength($value){

        $strong=0;

        //Set a min length
        if(strlen($value)>=8){
            $strong++;
        }

        //Force at least 1 special char
        if(preg_match("([\W]{1,})", $value)){
            $strong++;
        }

        //Force at least 1 lower case alpha char
        if(preg_match("([a-z]{1,})", $value)){
            $strong++;
        }

        //Force at least 1 upper case alpha char
        if(preg_match("([A-Z]{1,})", $value)){
            $strong++;
        }

        //Force at least 1 numeric char
        if(preg_match("([0-9]{1,})", $value)){
            $strong++;
        }

        return $strong===5?true:false;
    }

    // 2. Compare passwords 
    public function matchPassword($value){

        if($this->data['password'] === $value){
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

            if($this->{$rule['rule']} ($this->data[$field]) === false){
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
```


Now that we have extended our validation to account for new password rules we will add validation to our registration page.

*/public/register.php*
```php
<?php
require '../core/session.php';
require '../core/db_connect.php';
require '../core/About/src/Validation/Validate.php';

use About\Validation;

$valid = new About\Validation\Validate();
$message=null;

$input = filter_input_array(INPUT_POST,[
    'first_name'=>FILTER_SANITIZE_STRING,
    'last_name'=>FILTER_SANITIZE_STRING,
    'email'=>FILTER_SANITIZE_EMAIL,
    'password'=>FILTER_UNSAFE_RAW,
    'confirm_password'=>FILTER_UNSAFE_RAW
]);

if(!empty($input)){

    $valid->validation = [

        'email'=>[[
            'rule'=>'email',
            'message'=>'Please enter a valid email'
        ],[
            'rule'=>'notEmpty',
            'message'=>'Please enter a email'
        ]],

        'first_name'=>[[
            'rule'=>'notEmpty',
            'message'=>'Please enter a first name'
        ]],

        'last_name'=>[[
            'rule'=>'notEmpty',
            'message'=>'Please enter a last name'
        ]],

        'password'=>[[
            'rule'=>'notEmpty',
            'message'=>'Please enter a password'
        ],[
            'rule'=>'strength',
            'message'=>'Must contain [\Wa-zA-Z0-9]'
        ]],

        'confirm_password'=>[[
            'rule'=>'notEmpty',
            'message'=>'Please confirm your password'
        ],[
            'rule'=>'matchPassword',
            'message'=>'Passwords do not match'
        ]],

    ];

    $valid->check($input);

    if(empty($valid->errors)){
        //Strip white space, beginning and end
        $input = array_map('trim', $input);
        $hash = password_hash($input['password'], PASSWORD_DEFAULT); 

        $sql='INSERT INTO 
            users 
        SET 
            id=UUID(),
            email=:email,
            first_name=:first_name,
            last_name=:last_name,
            hash=:hash
        ';

        $stmt=$pdo->prepare($sql);

        try {

            $stmt->execute([
                'email'=>$input['email'],
                'first_name'=>$input['first_name'],
                'last_name'=>$input['last_name'],
                'hash'=>$hash
            ]);

            header('LOCATION: /login.php');

        } catch(PDOException $e) {
            $message="<div class=\"alert alert-danger\">{$e->errorInfo[2]}</div>";
        }
    }else{
        //3. If validation fails create a message, DO NOT forget to add the validation 
        //methods to the form.
        $message = "<div class=\"alert alert-danger\">Your form has errors!</div>";
    }

    
}

$meta=[];
$meta['title']="Register";

$content=<<<EOT
<h1>{$meta['title']}</h1>
{$message}
<form method="post" autocomplete="off">

    <div class="form-group">
        <label for="email">Email</label>
        <input 
            class="form-control" 
            id="email" 
            name="email" 
            type="email"
            value="{$valid->userInput('email')}"
        >
        <div class="text text-danger">{$valid->error('email')}</div>
    </div>

    <div class="form-group">
        <label for="first_name">First Name</label>
        <input 
            class="form-control" 
            id="first_name" 
            name="first_name"
            value="{$valid->userInput('first_name')}"
        >
        <div class="text text-danger">{$valid->error('first_name')}</div>
    </div>


    <div class="form-group">
        <label for="last_name">Last Name</label>
        <input 
            class="form-control" 
            id="last_name" 
            name="last_name" 
            value="{$valid->userInput('last_name')}"
        >
        <div class="text text-danger">{$valid->error('last_name')}</div>
    </div>

    <div class="form-group">
        <label for="password">Password</label>
        <input 
            class="form-control" 
            id="password" 
            name="password" 
            type="password"
            value="{$valid->userInput('password')}"
        >
        <div class="text text-danger">{$valid->error('password')}</div>
    </div>

    <div class="form-group">
        <label for="confirm_password">Confirm Password</label>
        <input 
            class="form-control" 
            id="confirm_password" 
            name="confirm_password" 
            type="password"
            value="{$valid->userInput('confirm_password')}"
        >
        <div class="text text-danger">{$valid->error('confirm_password')}</div>
    </div>

    <input type="submit" class="btn btn-primary">

</form>
EOT;

require '../core/layout.php';
```

Now we have the ability to register a user. Now we need to allow that user to login.

## Authenticating a User

Let us revisit the login mock-up in which we

* required a session file
* listened for a post request
* created a session on post
* provided just enough of a form to create a post

*public/login.php*
```php
<?php
// 1. Require your session file, this contains session_start()
require '../core/session.php';


// 2. Listen for a POST request. On Post set a session. 
// In the next iteration we replace this with authentication logic.
$_POST['id']=12345;//Force a valid POST
if(!empty($_POST)){
    // 3. On post, create a user session
    $_SESSION['user'] = [];
    $_SESSION['user']['id']=$_POST['id'];
    header('LOCATION: ' . $_GET['goto']);
}

// 4. Provide just enough of a form to initiate a POST
$content=<<<EOT
<form method="post">
    <input name="goto" value="{$_GET['goto']}">
    <input type="submit" class="btn btn-primary">
</form>
EOT;

require '../core/layout.php';
```

Now that we have a refreshed look at the mock-up, lets implement a complete login form.

* Replace the heredoc containing the form with:
  * email
  * password
* Wrap the form fields in bootstrap classes
* Add a title and metadata to the page


*public/login.php*
```php
<?php

require '../core/session.php';

$_POST['id']=12345;//Force a valid POST
if(!empty($_POST)){
    // 3. On post, create a user session
    $_SESSION['user'] = [];
    $_SESSION['user']['id']=$_POST['id'];
    header('LOCATION: ' . $_GET['goto']);
}

// 3. Add a page title
$meta=[];
$meta['title']="Login";

$content=<<<EOT
<!-- 3 Add page title -->
<h1>{$meta['title']}</h1>

<form method="post" autocomplete="off">

    <!-- 1.1 Add email -->
    <!-- 2 Add bootstrap classes -->
    <div class="form-group">
        <label for="email">Email</label>
        <input 
            class="form-control"
            id="email"
            name="email"
            type="email"
        >
    </div>

    <!-- 1.2 Add password -->
    <!-- 3 Add bootstrap classes -->
    <div class="form-group">
        <label for="password">Password</label>
        <input 
            class="form-control" 
            id="password" 
            name="password" 
            type="password"
        >
    </div>

    <input name="goto" value="{$goto}" type="hidden">
    <input type="submit" class="btn btn-primary">

</form>
EOT;

require '../core/layout.php';
```

Now that we have a login form, we will need to process the data.

* Connect to the database so that we can look up the credentials supplied by the user
* Filter the user inputs
* Check for a post request to determine if we have data to process
* Query the database for the requested user
* If the query was successful
  * Attempt a password match
* If the password match was successful
  * set a session
  * redirect the user the desired location (if applicable)




*public/login.php*
```php
<?php
require '../bootstrap.php';
// 1. Connect to the database
require '../core/db_connect.php';

// 2. Filter the user inputs
$input = filter_input_array(INPUT_POST,[
    'email'=>FILTER_SANITIZE_EMAIL,
    'password'=>FILTER_UNSAFE_RAW
]);

// 3. Check for a POST request
if(!empty($input)){

    // 4. Query the database for the requested user
    $input = array_map('trim', $input);
    $sql='SELECT id, hash FROM users WHERE email=:email';
    $stmt=$pdo->prepare($sql);
    $stmt->execute([
        'email'=>$input['email']
    ]);
    $row=$stmt->fetch();

    if($row){
        // 5. Attempt a password match
        $match = password_verify($input['password'], $row['hash']);
        if($match){
            // 6.1 Set a session
            $_SESSION['user'] = [];
            $_SESSION['user']['id']=$row['id'];

            // 6.2 Redirect the user
            header('LOCATION: ' . $_POST['goto']);
        }
    }
}
$meta=[];
$meta['title']="Login";

$content=<<<EOT
<h1>{$meta['title']}</h1>
<form method="post" autocomplete="off">
    <div class="form-group">
        <label for="email">Email</label>
        <input 
            class="form-control"
            id="email"
            name="email"
            type="email"
        >
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input 
            class="form-control" 
            id="password" 
            name="password" 
            type="password"
        >
    </div>
    <input name="goto" value="{$goto}" type="hidden">
    <input type="submit" class="btn btn-primary">
</form>
EOT;

require '../core/layout.php';
```

Check and set session on page load. Add sanitized content login form, we will need to process the data.
* Replace top content through `<meta charset="UTF-8">` with:

*core/layout.php*
```
<!-- Set session in php -->
<?php
function active($name){
  $current = $_SERVER['REQUEST_URI'];
  if($current === $name){
    return 'active';
  }

  return null;
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
<!-- Add sanitized content -->
  <?php if(!empty($meta)): ?>

<?php if(!empty($meta['title'])): ?>
  <title><?php echo $meta['title']; ?></title>
<?php endif; ?>

<?php if(!empty($meta['description'])): ?>
  <meta name="description" content="<?php echo $meta['description']; ?>">
<?php endif; ?>

<?php if(!empty($meta['keywords'])): ?>
  <meta name="keywords" content="<?php echo $meta['keywords']; ?>">
<?php endif; ?>

<?php endif; ?>
<!-- End sanitized content -->

      <meta charset="UTF-8">
```

## Bootstraping

Currently, we have several includes at the top of every page, some of which are common to all pages. When this occurs a common practice to load what is known as a bootstrap file aptly named *bootstrap.php*. One issue posed by bootstraping is the use of includes in the bootstrap file. Any time a file is included/required it executes as though it is code written on the calling page. Our application is written is a tree structure which means including via relative paths will not work when traversing a nested folder structure. Another common practice is to define a *ROOT* constant which will be used to prefix all includes with the exception of the bootstrap file.

```php
<?php
// 1. Define a ROOT constant
define('ROOT', '/var/www/example.com');

//2. Call common files
require ROOT . '/core/session.php';
require ROOT . '/config/keys.php';
```

Now replace all instances of *[../]../core/session.php* and *[../]../config/keys.php* with a call to *[../]../core/bootstrap.php* as needed.

## Labs

* Throw an error message if user authentication fails
* Remove admin links for non-admins
* Implement a password reset
* Create a password reset request process.

## Additional Resources
* [$_SESSION](https://www.php.net/manual/en/reserved.variables.session.php)
* [Session Handling in PHP](https://www.php.net/manual/en/book.session.php)
* [SessionHandlerInterface in PHP](https://www.php.net/manual/en/class.sessionhandlerinterface.php)
* [Code Review](https://codereview.stackexchange.com/questions/193504/php-7-1-mysql-session-handler-class-with-some-built-in-time-management-secur)
