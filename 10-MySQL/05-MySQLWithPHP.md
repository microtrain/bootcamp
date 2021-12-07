# MySQL with PHP

In this lesson, we will use PHP's PDO library to work with our database. 

The first step is to create a connection to your database. Your connection script will likely be part of a larger configuration.

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

Create the file */var/www/example.com/public/posts/index.php*
```php
<?php
include '../../core/db_connect.php';
```
Preview this file in your browser [http://localhost/example.com/public/posts/index.php](http://localhost/example.com/public/posts/index.php)

Update posts/index.php as follows
```php
<?php
include '../../core/db_connect.php';

$stmt = $pdo->query("SELECT * FROM posts");

while ($row = $stmt->fetch())
{
    var_dump($row);
}
```

Replace the ```var_dump()``` with real output
```php
<?php
include '../../core/db_connect.php';

$content=null;
$stmt = $pdo->query("SELECT * FROM posts");

while ($row = $stmt->fetch())
{

    $content .= "<a href=\"post?slug={$row['slug']}\">{$row['title']}</a>";
}

echo $content;
```

Add the template
```php
<?php
include '../../core/db_connect.php';

$content=null;
$stmt = $pdo->query("SELECT * FROM posts");

while ($row = $stmt->fetch())
{

    $content .= "<a href=\"view.php?slug={$row['slug']}\">{$row['title']}</a>";
}

include '../../core/layout.php';
```

Create a copy of posts/index.php called view.php
```php
<?php
include '../../core/db_connect.php';

$slug = "'{$_GET['slug']}'";

$content=null;
$stmt = $pdo->query("SELECT * FROM posts WHERE slug={$slug}");

while ($row = $stmt->fetch())
{

    $content .= "<a href=\"view.php?slug={$row['slug']}\">{$row['title']}</a>";
}

echo $content;
```
Change as follows. Everything about this is wrong - why?
```php
<?php
include '../../core/db_connect.php';

$slug = "'{$_GET['slug']}'";

$content=null;
$stmt = $pdo->query("SELECT * FROM posts WHERE slug={$slug}");

$row = $stmt->fetch();
$content .= "<h1>{$row['title']}</h1>";

echo $content;
```
In short, we are trusting user input. If I were to replace the $_GET param as follows we will get the same result. Why is this terrifying?  

```php
<?php
include '../../core/db_connect.php';

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

The other issue is that we are directly accessing superglobals which nowadays is considered bad practice. To further restrict the user input sanitize the slug by forcing it into a predefined format.
```php
<?php
include '../../core/db_connect.php';

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

### Create a Post

*posts/add.php*
```php
<?php
require '../../config/keys.php';
require '../../core/db_connect.php';

$args = [
    'title'=>FILTER_SANITIZE_STRING,
    'meta_description'=>FILTER_SANITIZE_STRING,
    'meta_keywords'=>FILTER_SANITIZE_STRING,
    'body'=>FILTER_UNSAFE_RAW
];

$input = filter_input_array(INPUT_POST, $args);

if(!empty($input)){

    $input = array_map('trim', $input);

    $slug = preg_replace(
        "/[^a-z0-9-]+/",
        "-",
        strtolower($input['title'])
    );

    $sql = 'INSERT INTO posts SET id=uuid(), title=?, slug=?, body=?';
    if($pdo->prepare($sql)->execute([
        $input['title'],
        $slug,
        $input['body']
    ])){
       header('LOCATION:/posts');
    }else{
        $message = 'Something bad happened';
    }
}

$content = <<<EOT
<h1>Add a New Post</h1>
<form method="post">

<div class="form-group">
    <label for="title">Title</label>
    <input id="title" name="title" type="text" class="form-control">
</div>

<div class="form-group">
    <label for="body">Body</label>
    <textarea id="body" name="body" rows="8" class="form-control"></textarea>
</div>

<div class="row">
    <div class="form-group col-md-6">
        <label for="meta_description">Description</label>
        <textarea id="meta_description" name="meta_description" rows="2" class="form-control"></textarea>
    </div>

    <div class="form-group col-md-6">
        <label for="meta_keywords">Keywords</label>
        <textarea id="meta_keywords" name="meta_keywords" rows="2" class="form-control"></textarea>
    </div>
</div>

<div class="form-group">
    <input type="submit" value="Submit" class="btn btn-primary">
</div>
</form>
EOT;

include '../../core/layout.php';
```

#### Refactor
*posts/add.php*
```sh
<?php
require '../../core/functions.php';
require '../../config/keys.php';
require '../../core/db_connect.php';

$message=null;

$args = [
    'title'=>FILTER_SANITIZE_STRING, //strips HMTL
    'meta_description'=>FILTER_SANITIZE_STRING, //strips HMTL
    'meta_keywords'=>FILTER_SANITIZE_STRING, //strips HMTL
    'body'=>FILTER_UNSAFE_RAW  //NULL FILTER
];

$input = filter_input_array(INPUT_POST, $args);

if(!empty($input)){

    //Strip white space, begining and end
    $input = array_map('trim', $input);

    //Allow only whitelisted HTML
    $input['body'] = cleanHTML($input['body']);

    //Create the slug
    $slug = slug($input['title']);

    //Sanitiezed insert
    $sql = 'INSERT INTO posts SET id=uuid(), title=?, slug=?, body=?';

    if($pdo->prepare($sql)->execute([
        $input['title'],
        $slug,
        $input['body']
    ])){
       header('LOCATION:/posts');
    }else{
        $message = 'Something bad happened';
    }
}

$content = <<<EOT
<h1>Add a New Post</h1>
{$message}
<form method="post">

<div class="form-group">
    <label for="title">Title</label>
    <input id="title" name="title" type="text" class="form-control">
</div>

<div class="form-group">
    <label for="body">Body</label>
    <textarea id="body" name="body" rows="8" class="form-control"></textarea>
</div>

<div class="row">
    <div class="form-group col-md-6">
        <label for="meta_description">Description</label>
        <textarea id="meta_description" name="meta_description" rows="2" class="form-control"></textarea>
    </div>

    <div class="form-group col-md-6">
        <label for="meta_keywords">Keywords</label>
        <textarea id="meta_keywords" name="meta_keywords" rows="2" class="form-control"></textarea>
    </div>
</div>

<div class="form-group">
    <input type="submit" value="Submit" class="btn btn-primary">
</div>
</form>
EOT;

include '../../core/layout.php';
```

*core/functions.php*
```php
<?php

/**
 * Strips HTML tags that have not been white listed
 * @var string $html Unsanitized HTML
 * @return string Sanitized HTML
 */
function cleanHTML($html){

  $allowed = '<div><span><pre><p><br><hr><hgroup><h1><h2><h3><h4><h5><h6>
  <ul><ol><li><dl><dt><dd><strong><em><b><i><u>
  <img><a><abbr><address><blockquote><area><audio><video>
  <form><fieldset><label><input><textarea>
  <caption><table><tbody><td><tfoot><th><thead><tr>';

  return strip_tags($html, $allowed);
}

/**
 * Creates a slug from a given string
 * @var string $string
 * @return string
 */
function slug($string){
  return preg_replace(
    "/[^a-z0-9-]+/",
    "-",
    strtolower($string)
  );
}
```

#### Add Validation

This would be an extension of the validation for contact.php

### Update a Post
Make a copy of add.php and rename it edit.php

```sh
<?php
require '../../core/functions.php';
require '../../config/keys.php';
require '../../core/db_connect.php';

// Get the post
$get = filter_input_array(INPUT_GET);
$id = $get['id'];

$stmt = $pdo->prepare("SELECT * FROM posts WHERE id=:id");
$stmt->execute(['id'=>$id]);

$row = $stmt->fetch();

//If the id cannot be found kill the request
if(empty($row)){
  http_response_code(404);
  die('Page Not Found <a href="/">Home</a>');
}

//var_dump($row);
$meta=[];
$meta['title']= "Edit: {$row['title']}";

// Update the post
$message=null;

$args = [
    'id'=>FILTER_SANITIZE_STRING, //strips HMTL
    'title'=>FILTER_SANITIZE_STRING, //strips HMTL
    'meta_description'=>FILTER_SANITIZE_STRING, //strips HMTL
    'meta_keywords'=>FILTER_SANITIZE_STRING, //strips HMTL
    'body'=>FILTER_UNSAFE_RAW  //NULL FILTER
];

$input = filter_input_array(INPUT_POST, $args);

if(!empty($input)){

    //Strip white space, begining and end
    $input = array_map('trim', $input);

    //Allow only whitelisted HTML
    $input['body'] = cleanHTML($input['body']);

    //Create the slug
    $slug = slug($input['title']);

    //Sanitized insert
    $sql = 'UPDATE
        posts
      SET
        title=:title,
        slug=:slug,
        body=:body,
        meta_description=:meta_description,
        meta_keywords=:meta_keywords
      WHERE
        id=:id';

    if($pdo->prepare($sql)->execute([
        'title'=>$input['title'],
        'slug'=>$slug,
        'body'=>$input['body'],
        'meta_description'=>$input['meta_description'],
        'meta_keywords'=>$input['meta_keywords'],
        'id'=>$input['id']
    ])){
       header('LOCATION:./view.php?slug=' . $row['slug']);
    }else{
        $message = 'Something bad happened';
    }
}

$content = <<<EOT
<h1>Edit: {$row['title']}</h1>
{$message}
<form method="post">

<input id="id" name="id" value="{$row['id']}" type="hidden">

<div class="form-group">
    <label for="title">Title</label>
    <input id="title" value="{$row['title']}" name="title" type="text" class="form-control">
</div>

<div class="form-group">
    <label for="body">Body</label>
    <textarea id="body" name="body" rows="8"
      class="form-control"
      >{$row['body']}
    </textarea>
</div>

<div class="row">
    <div class="form-group col-md-6">
        <label for="meta_description">Description</label>
        <textarea id="meta_description" name="meta_description" rows="2"
          class="form-control"
          >{$row['meta_description']}</textarea>
    </div>

    <div class="form-group col-md-6">
        <label for="meta_keywords">Keywords</label>
        <textarea id="meta_keywords" name="meta_keywords" rows="2"
          class="form-control"
          >{$row['meta_keywords']}</textarea>
    </div>
</div>

<div class="form-group">
    <input type="submit" value="Submit" class="btn btn-primary">
</div>
</form>
<br><hr><br>
EOT;

include '../../core/layout.php';
```

#### Add Navigation

Add to view.php
```
$content .="<p><a href=\"edit.php?id={$row['id']}\">Edit Post</a><br>";
```

### Delete a Post
This could be anything from a blank page with a redirect after deletion to a page that returns some details and asks you to confirm your delete.
```sh
<?php
require '../../config/keys.php';
require '../../core/db_connect.php';

$args=[
  'id'=>FILTER_UNSAFE_RAW,
  'confirm'=>FILTER_VALIDATE_INT
];

$input = filter_input_array(INPUT_GET, $args);
$id=$input['id'];

$stmt = $pdo->prepare("SELECT * FROM posts WHERE id=:id");
$stmt->execute(['id'=>$id]);
$row = $stmt->fetch();

if(!empty($input['confirm'])){
  $stmt = $pdo->prepare("DELETE FROM posts WHERE id=:id");
  if($stmt->execute(['id'=>$id])){
    header('Location: /example.com/public/posts/');
  }
}

$meta=[];
$meta['title']="DELETE: {$row['title']}";

$content=<<<EOT
<h1 class="text-danger text-center">DELETE: {$row['title']}</h1>
<p class="text-danger text-center">Are you sure you want to delete {$row['title']}?</p>

<div class="text-center">
  <a href="./" class="btn btn-success btn-lg">Cancel</a>
  <br><br>
  <a href="delete.php?id={$row['id']}&confirm=1" class="btn btn-link text-danger">Delete</a>
</div>
<hr>
<br>
EOT;

require '../../core/layout.php';
```

#### Add Navigation

Add to view.php
```
$content .="<p><a href=\"delete.php?id={$row['id']}\">Delete</a><br>";
```
Add to index.php
```
$content .="<p><a href=\"add.php\">New Post</a><br>";
```


## Lab Create a Users CRUD

You may start by creating a copy of the posts folder and doing a find and replace for the words post and user. Then you will adjust the column names accordingly.

### View Users
Make a copy of index.php

### Create a User
Make a copy of add.php

### Read a User
Make a copy of view.php

### Update a User
Make a copy of edit.php

### Delete a User
This could be anything from a blank page with a redirect after deletion to a page that returns some details and asks you to confirm your delete. delete.php


[Commit Log Previous Class](https://github.com/microtrain1812/example.com/commits/master)

[Next: Authentication with MySQL and PHP](06-Authentication.md)


