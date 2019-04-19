# Authentication with MySQL and PHP

This section will cover the basics of sessions, user authentication, and registration.

Simply stated, sessions provide a way to maintain state between a client and a server. A typical session has an id and expiration timestamp. A server will create a session with an id, the server will then send a cookie to the client. This cookie will have a session id. This id is how a given client is able to maintain a unique state with a given server. In the context of authentication, anytime a client makes a request to a server it sends the cookie along with the request, the server reads the id from the it's session store. If the server can match the id provide by the cookie to a record in the session store and that cookie has not expired then the user is considered to have been authenticated under an active session. The actual authentication would have ocurred during a login in which a user would have provided credentials; typically a username and password to the server. Upon the server verifying these credentials a session record would be stored serve side and a cookie would be sent to the browser. Sessions and cookies may both store additional data depending on the needs of the session and or cookie. By default, PHP stores sessions in a flat file on the server the originated the session. This can be configured to use any data store either on the origination server or against a central data store. While classic databases such as Oracle, MySQL and MongoDB are not uncommon, in memory databases such as Reddis are gaining popularity.

## Working with Sessions

PHP provides a ```$_SESSION``` super global. You may access this super global directly or through an abstraction layer. PHP also provides a [SessionHandlerInterface](https://www.php.net/manual/en/class.sessionhandlerinterface.php) for more complicated configurations. While working with directly with a super global tends o be discouraged we will do it here because I want to focus on the functionality.


*/var/www/example.com/core/session.php*
```php
<?php
//Any page that  works with session data MUST include start_session()
start_session();

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

Add the following to every page on the the website. The key is the first line ```session_start()```. Call this on every page to assure state is not lost.
```php
require '../core/sessions.php';
```

Add the following to every page that would require authentication. This would force the user back to the home page anytime ```$_SESSION['user']['id']``` equates to empty.

```php
checkSession();
```

### Login (Mock Up)
We will add some proof of concept code to help us better understand how the session works. This is will create a valid user session without performing the normal authentication logic. This is concept is often referred to as a mock up.

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
Try to access users by clicking on the users link and you will be redirected to the login page. Clicking the submit button initiate a POST request and populate ```$_SESSION['user']['id']```. The *goto* parameter will be appended to the LOCATION header and you will be redirected to the users page. Having an active session you will now have access to every file calling ```checkSession()```. At ant point, clicking the Logout link will end the session and deny you further access to the restricted areas.

## Authentication

Now that we can create a session we will need to provide a means of user authentication. We will do this by adding a hash to our users table and creating a user authentication page. 

Open a MySQL cli and log into the database.
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

Once the form has been created we can filter the form fields and process the form. We will start by adding input filters and use a simple ```var_dump()``` to verify all the inputs (aka: POST parameters) are getting passed. 

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

Add validation methods to test password strength and compare the ```password``` to ```compare_password```. 


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

    // 1. Password strength 
    public function strength($value){

        $strong=0;

        if(strlen($value)>=8){
            $strong++;
        }

        if(preg_match("([\W]{1,})", $value)){
            $strong++;
        }

        if(preg_match("([a-z]{1,})", $value)){
            $strong++;
        }

        if(preg_match("([A-Z]{1,})", $value)){
            $strong++;
        }

        if(preg_match("([0-9]{1,})", $value)){
            $strong++;
        }

        return $strong===5?true:false;
    }

    // 2. Compare passwords 
    function matchPassword($value){

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
        //Strip white space, begining and end
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



## Additional Resources
* [$_SESSION](https://www.php.net/manual/en/reserved.variables.session.php)
* [Session Handling in PHP](https://www.php.net/manual/en/book.session.php)
* [SessionHandlerInterface in PHP](https://www.php.net/manual/en/class.sessionhandlerinterface.php)
* [Code Review](https://codereview.stackexchange.com/questions/193504/php-7-1-mysql-session-handler-class-with-some-built-in-time-management-secur)
