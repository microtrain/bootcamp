Since meta tags belong in the document we will want to add them to the template. We will need to be able to set these on a page by page basis so these should be passed as a variable from the page in question.
```php
$meta = [];
$meta['description'] = "The best thing about hello world is the greeting";
$meta['keywords'] = "hello world, hello, world";

<meta name="description" content="<?php echo $meta['description']; ?>">
<meta name="keywords" content="<?php echo $meta['keywords']; ?>">
```

For example *contact.php* might read as follows. Rather than an array, perhaps a herdoc containing any meta tags you want to include would be preferred.
```php
<?php

require 'core/processContactForm.php';

//Build the page metadata
$meta = [];
$meta['description'] = "The best thing about hello world is the greeting";
$meta['keywords'] = "hello world, hello, world";

//Build the page content
$content = <<<EOT
<form method="post" action="contact.php">
  {$message} ...
EOT;

require 'core/layout.php';
```
