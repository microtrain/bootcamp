# MySQL with PHP

In this lesson we will use PHP's PDO library to work with our database.

The first step is to create a connection to your database. You connection script will likely be part of larger configuration.

Under your example.com create the file *core/db_connect.php*

```php
<?php

$host = '127.0.0.1';
$db   = 'bootcamp';
$user = 'root';
$pass = 'password';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
try {
     $pdo = new PDO($dsn, $user, $pass, $options);
     var_dump($pdo);
} catch (\PDOException $e) {
     throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
```

Create the file */var/www/example.com/webroot/posts/index.php*
```php
<?php
include '../core/db_connect.php';
```
Preview this file in your browser [http://localhost/example.com/webroot/posts/index.php](http://localhost/example.com/webroot/posts/index.php)

Update posts/index.php as follows
```php
<?php
include '../core/db_connect.php';

$stmt = $pdo->query("SELECT * FROM posts");

while ($row = $stmt->fetch())
{
    var_dump($row);
}
```

Replace the ```var_dump()``` with real output
```php
<?php
include '../core/db_connect.php';

$content=null;
$stmt = $pdo->query("SELECT * FROM posts");

while ($row = $stmt->fetch())
{

    $content .= "<a href=\"post?slug={$row['slug']}\">{$row['title']}</a>";
}

echo $content;
```

Add the template
```
<?php
include '../core/db_connect.php';

$content=null;
$stmt = $pdo->query("SELECT * FROM posts");

while ($row = $stmt->fetch())
{

    $content .= "<a href=\"post.php?slug={$row['slug']}\">{$row['title']}</a>";
}

include '../core/layout.php';
```

Create a copy of posts/index.php called post.php
```php
<?php
include '../core/db_connect.php';

$slug = "'{$_GET['slug']}'";

$content=null;
$stmt = $pdo->query("SELECT * FROM posts WHERE slug={$slug}");

while ($row = $stmt->fetch())
{

    $content .= "<a href=\"post.php?slug={$row['slug']}\">{$row['title']}</a>";
}

echo $content;
```
Change as follows. Everything about this is wrong - why?
```php
<?php
include '../core/db_connect.php';

$slug = "'{$_GET['slug']}'";

$content=null;
$stmt = $pdo->query("SELECT * FROM posts WHERE slug={$slug}");

$row = $stmt->fetch();
$content .= "<h1>{$row['title']}</h1>";

echo $content;
```
In short, we are trustung user input. If I were to replace the $_GET param as follows we will get the same result. Why is this terrifying?  

```php
<?php
include '../core/db_connect.php';

//$slug = "'{$_GET['slug']}'";
$slug="(SELECT slug FROM posts WHERE slug = 'hello')";

$content=null;
$stmt = $pdo->query("SELECT * FROM posts WHERE slug={$slug}");

$row = $stmt->fetch();
$content .= "<h1>{$row['title']}</h1>";

echo $content;
```
Because we just allowed a subquery as a parameter. There are several ways to defeat this, the first is by simply adding quotes to the query, but this only works if the expected input is a string.

```php
$stmt = $pdo->query("SELECT * FROM posts WHERE slug={$slug}");
```

The preferred method is a prepared statement with bound parameters. There are two ways to do this commonly referred to as unnamed and named.

In an unnamed binding the order matters.
```php
$stmt = $pdo->prepare('SELECT * FROM posts WHERE slug = ?');
$stmt->execute([$slug]);
```

In a named binding the order does not matter. 
```php
$stmt = $pdo->prepare('SELECT * FROM posts WHERE slug = :slug');
$stmt->execute(['slug' => $slug]);
```

The other issue is that we are directly accessing super globals which now-a-days is considered bad practice. To further restrict the user input sanitize the slug by forcing it into a predefined format.
```php
<?php
include '../core/db_connect.php';

$input = filter_input_array(INPUT_GET);
$slug = preg_replace("/[^a-z0-9-]+/", "", $input['slug']);

$content=null;
$stmt = $pdo->prepare('SELECT * FROM posts WHERE slug = ?');
$stmt->execute([$slug]);

$row = $stmt->fetch();
$content .= "<h1>{$row['title']}</h1>";

echo $content;
```

## Exercise

Add full CRUD functionality to the example.com project.
