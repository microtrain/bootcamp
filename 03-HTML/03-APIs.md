# API

An Application Programming Interface (API) is a means of providing programming hooks into a larger system. For example ````document.getElementById('el').style```` is a programming hook that allows a JavaScript programmer to work with the browser. Some APIs are open to the public and others are closed and accessible only by those who have been granted special access. Some APIs are accessible over Internet protocols.

## Mailgun API

### Exercise 1 - Getting Started with Mailgun.

Go to mailgun.org and create a free account. You may choose not to add a credit card as we will be working with the sandbox. You will need to activate your account via email and SMS, this requires a phone number that receive texts. If you do not have one try creating a Google Voice account.

The landing page will provide you the details you need need to send a test email. Start by creating a shell script and pasting the curl example into the shell.

````
vim ~/mailgun.sh
````

Add the line

````
#!/bin/bash
````

Then
* Copy and paste the curl command into the file.
* Make the file executable.
* Execute the script.

````
chmod +x mailgun.sh
./mailgun.sh
````

If you see a [json](http://www.json.org/) response similar to this, your sand box account is working.
````
{
  "id": "<20171009154755.125901.xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx.mailgun.org>",
  "message": "Queued. Thank you."
}
````

### Exercise 2 - Mailgun and PHP

The first thing you will want to do is [Mailgun's PHP](https://github.com/mailgun/mailgun-php) library to your project. You will do this via Composer.

Let's start by creating a feature branch. This will allow us to keep any changes separate from our production code until we are ready for it.

````
cd /var/www/about
git checkout -B feature/mailgun
````

If you get the message *Switched to a new branch 'feature/mailgun'* you are ready to proceed.
```
composer require mailgun/mailgun-php php-http/curl-client guzzlehttp/psr7
````

This may take a minute or so. The install was successful if you see a series of *Installing* messages ending with
````
Writing lock file
Generating autoload files
````

Now, let's see what was installed.
````
git status
````

You should see something like the following.
````
composer.json
composer.lock
vendor/
````

We do not want to commit the vendor directory to our repo. So we will create a *.gitignore* file. From you Atom sidebar create a file called *.gitignore* under the about project (Do not forget the preceding dot) and add the following line.
````
/vendor/
````

Now if you run ````git status```` you will see the following.
````
.gitignore
composer.json
composer.lock
````

Commit these files and push to the new feature branch.
````
git add .
git commit -m 'Added mailgun lib'
git push origin feature/mailgun
````

Create the file */var/www/about/test.php* and copy and paste the PHP sample code from the Mailgun landing page. Below the pasted code add the line ````var_dump($reults);````.

````
<?php
# Include the Autoloader (see "Libraries" for install instructions)
require 'vendor/autoload.php';
use Mailgun\Mailgun;

# Instantiate the client.
$mgClient = new Mailgun('key-xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx');
$domain = "sandboxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx.mailgun.org";

# Make the call to the client.
$result = $mgClient->sendMessage("$domain",
          array('from'    => 'Mailgun Sandbox <postmaster@sandboxdxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx.mailgun.org>',
                'to'      => 'YOUR-NAME <YOUR-EMAIL-ADDRESS>';
                'subject' => 'Hello YOUR-NAME',
                'text'    => 'Congratulations YOUR-NAME, you just sent an email with Mailgun! You are truly awesome! '));

var_dump($reults);
````

From a browser window, navigate to *http://localhost/about/test.php* and you should get a json string similar to:
````
object(stdClass)#24 (2) { ["http_response_body"]=> object(stdClass)#19 (2) { ["id"]=> string(91) "<20171009164718.79178.xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx.mailgun.org>" ["message"]=> string(18) "Queued. Thank you." } ["http_response_code"]=> int(200) }
````
Then check your email to see if it worked.


**Security Check Point**
_Never push a key to a public repository, use a key file the exists outside of the public repo_

## Exercise 2 - Pass Variables into the API Call

Create a key file
````
mkdir -p /var/www/conf
vim /var/www/conf/keys.php
````
Add the following (Where YOUR-KEY-HERE is the key provided by Mailgun):
````
<?php
define(MG_KEY, 'YOUR-KEY-HERE');
define(MG_DOMAIN, 'YOUR-DOMAIN-HERE');
````
Add the following to the top of *http://localhost/about/test.php*
````
require '/var/www/conf/keys.php';
````

Change
````
$mgClient = new Mailgun('key-xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx');
$domain = 'sandboxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx.mailgun.org';

$from = 'Mailgun Sandbox <postmaster@xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx.mailgun.org>';
````
to
````
$mgClient = new Mailgun(MG_KEY);
$domain = MG_DOMAIN;

$from = "Mailgun Sandbox <postmaster@{$domain}>";
````

Instead of passing static values into the method pass variables.
* Replace the existing method call with the following.
* Remove the var_dump($results);

````
$from = "Mailgun Sandbox <postmaster@{$domain}>";
$to = 'YOUR-NAME <YOUR-EMAIL-ADDRESS>';
$subject = 'Hello YOUR-NAME';
$text = 'Congratulations YOUR-NAME, you just sent an email with Mailgun! You are truly awesome!';

$result = $mgClient->sendMessage(
  $domain,
  array('from'    => $from,
        'to'      => $to,
        'subject' => $subject,
        'text'    => $text
    )
);
````
From a browser window, navigate to *http://localhost/about/test.php* and check your email.
