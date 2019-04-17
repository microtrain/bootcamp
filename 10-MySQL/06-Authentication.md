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

Any page for which we want to use and/or check sessions.
```php
//Usage
require '../core/sessions.php';
//checkSession();
```

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

We will add some proof of concept code to help us better understand how the session works.

*public/login.php*
```php
<?php
// 1. Require your session file, this contains session_start()
require '../core/session.php';


// 2. Listen for a POST request. On Post set a session. 
// In the next iteration we replace this with authentication logic.
if(!empty($_POST)){
    $_SESSION['user'] = [];
    $_SESSION['user']['id']=12345;
    header('LOCATION: ' . $_POST['goto']);
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

*/public/register.php*
```php

```



## Additional Resources
* [$_SESSION](https://www.php.net/manual/en/reserved.variables.session.php)
* [Session Handling in PHP](https://www.php.net/manual/en/book.session.php)
* [SessionHandlerInterface in PHP](https://www.php.net/manual/en/class.sessionhandlerinterface.php)
* [Code Review](https://codereview.stackexchange.com/questions/193504/php-7-1-mysql-session-handler-class-with-some-built-in-time-management-secur)
