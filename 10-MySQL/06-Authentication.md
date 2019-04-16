# Authentication with MySQL and PHP

This section will cover the basics of sessions, user authentication, and registration.

Simply stated, sessions provide a way to maintain state between a client and a server. A typical session has an id and expiration timestamp. A server will create a session with an id, the server will then send a cookie to the client. This cookie will have a session id. This id is how a given client is able to maintain a unique state with a given server. In the context of authentication, anytime a client makes a request to a server it sends the cookie along with the request, the server reads the id from the it's session store. If the server can match the id provide by the cookie to a record in the session store and that cookie has not expired then the user is considered to have been authenticated under an active session. The actual authentication would have ocurred during a login in which a user would have provided credentials; typically a username and password to the server. Upon the server verifying these credentials a session record would be stored serve side and a cookie would be sent to the browser. Sessions and cookies may both store additional data depending on the needs of the session and or cookie. By default, PHP stores sessions in a flat file on the server the originated the session. This can be configured to use any data store either on the origination server or against a central data store. While classic databases such as Oracle, MySQL and MongoDB are not uncommon, in memory databases such as Reddis are gaining popularity.

## Sessions in PHP

PHP provides a ```$_SESSION``` super global. You may access this super global directly or through an abstraction layer. PHP also provides a [SessionHandlerInterface](https://www.php.net/manual/en/class.sessionhandlerinterface.php) for more complicated configurations. While working with directly with a super global tends o be discouraged we will do it here because I want to focus on the functionality.


*/var/www/example.com/core/session.php*
```php
<?php
start_session();

//Redirects a user to a login page if there is no active session
function checkSession(){

  $hasSession=false;
  if(!empty($_SESSION['user']['id'])){
    $hasSession=true;
  }

  if($hasSession===false){
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

*public/logout.php*
```php
<?php
require '../core/session.php';

$_SESSION=[];
header('LOCATION: /');
```

*public/login.php*
```php
<?php
require '../core/session.php';

if(!empty($_POST)){
    $_SESSION['user'] = [];
    $_SESSION['user']['id']=12345;
    header('LOCATION: ' . $_POST['goto']);
}

$content=<<<EOT
<form method="post">
    <input name="goto" value="{$_GET['goto']}">
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
