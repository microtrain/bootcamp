# CakePHP

CakePHP is an MVC (Model, View, Controller) based rapid application development (RAD) framework built using PHP. CakePHP has a solid eco-system and is designed around test-driven development (TDD).

## CRUD

Create, Read, Update, Delete

## Migrations
Rolling snapshots of the database structure. These allow you to migrate your database's structure forward and backward across snapshots.

## Create a Repository on GitHub

* Create the repository *cake.example.com*.
* **DO NOT** Initialize with a README
* **DO NOT** Add the MIT License

## Installation

First, make sure you have installed internationalization functions for PHP.
```sh
sudo apt-get install php-intl
```

Create a CakePHP project via composer. Sticking with the _example.com_ nomenclature we will call this one _cake.example.com_.
```sh
cd /var/www
composer create-project --prefer-dist cakephp/app cake.example.com
```

Answer yes to the following
```sh
Set Folder Permissions ? (Default to Y) [Y,n]?
```

## Your First App
Move into the new project folder
```sh
cd cake.example.com
```

Spin up a development web server.
```sh
bin/cake server
```

In a browser go to [http://localhost:8765/](http://localhost:8765/). You will be presented with a default home page that shows that gives you plenty of resources to help you learn CakePHP and it will return a system status that makes sure you system is set up correctly. Everything should be green except for the database.

![default home page](/img/cakephp/default_home.png)

Add *cake.example.com* as a project to VSC. Navigate to *config/app.php* this is the default configuration file for your application. CakePHP stores its configuration as an array, find the *Datasources* attribute somewhere around the line *220* (you can use the shortcut [ctrl] + [g] and enter *220*). You will notice two-child attributes *default* and *test*. *default* holds the configuration for your application's database while test holds the configuration for running unit tests.

### Setup Your Database

We will use PhpMyAdmin to create two databases
* cake_app
* cake_test

Go to [http://localhost/phpmyadmin](http://localhost/phpmyadmin) and login as with _root:password_. Find the Databases tab and under the _Create database_ header enter *cake_app* as your first database. This will now ask you to create a table, skip this step and find your way back to the Databases tab and create another database called *cake_test* you can now close out of phpMyAdmin and return to the _app.php_ file in VSC.

![phpMyAdmin](/img/cakephp/createdb.png)

Update the database configurations as follows.

_default_
```php
'username' => 'root',
'password' => 'password',
'database' => 'cake_app',
```

_test_
```php
'username' => 'root',
'password' => 'password',
'database' => 'cake_test',
```

Return to http://localhost:8765/](http://localhost:8765/) and refresh the page, all settings should now be green.

### Configure Apache

Let's set up an Apache configuration with a localhost entry for development purposes.

````sh
sudo vim /etc/apache2/sites-available/cake.example.com.conf
````

```apache
<VirtualHost 127.0.0.101:80>

        ServerName loc.cake.example.com

        ServerAdmin webmaster@localhost
        DocumentRoot /var/www/cake.example.com/webroot

        # Allow an .htaccess file to ser site directives.
        <Directory /var/www/cake.example.com/webroot/>
                AllowOverride All
        </Directory>

        # Available loglevels: trace8, ..., trace1, debug, info, notice, warn,
        # error, crit, alert, emerg.
        # It is also possible to configure the loglevel for particular
        # modules, e.g.
        #LogLevel info ssl:warn

        ErrorLog ${APACHE_LOG_DIR}/error.log
        CustomLog ${APACHE_LOG_DIR}/access.log combined

</VirtualHost>
```

Be sure to load mod_rewrite
```sh
sudo a2enmod rewrite
sudo systemctl reload apache2
```

Add the following to */etc/hosts*

```sh
127.0.0.101      loc.cake.example.com
```

and finally, load the new site.
```sh
sudo a2ensite cake.example.com && sudo service apache2 restart
```

Navigate to [http://loc.cake.example.com/](http://loc.cake.example.com/) and you should encounter write permission issues. Resolve this by changing ownership of these files to the Apache process (www-data) and the current user ($USER).
```sh
sudo chown www-data:$USER logs
sudo chown www-data:$USER logs/*
sudo chown www-data:$USER tmp
sudo chown www-data:$USER tmp/*
sudo chown www-data:$USER tmp/*/*
sudo chown www-data:$USER tmp/*/*/*
```

Return to [http://loc.cake.example.com/](http://loc.cake.example.com/) and all systems should now be a go.

### Merge with the Existing GitHub Project

[</> Code](https://github.com/stack-x/cake.example.com/commit/5206abb675ad8decf9664a543e2d3022c42a17f5) Run the following commands, be sure to replace YOUR-GITHUB-USERNAME with your GitHub username.

```sh
cd /var/www/cake.example.com
git init
git remote add origin git@github.com:YOUR-GITHUB-USERNAME/cake.example.com.git
git pull origin master
git add .
git commit -am 'Initial build'
git push origin master
```

### Cake File Structure, Callbacks, and Routing

@todo navigate to src, explain the directory structure Model, Views and Controller
@todo callback methods and life cycles as it pertains to a CakePHP and Programming in general.

<!--
## Build a Blog

We will start by using Composer to install CakeDC's [User Authentication plugin](https://github.com/CakeDC/users). We will then bake a Posts CRUD which we will use for posting to our blog. In your console, please navigate to **/var/www/cake.example.com**, this tutorial assumes **/var/www/cake.example.com** as the base path for all cd, file and folder creation commands.
-->
### Users

We will start by using Composer to install CakeDC's [User Authentication plugin](https://github.com/CakeDC/users). This will serve as the foundation of our application.

1. We will install the users plugin developed by CakeDC. The documentation is available [here](https://github.com/CakeDC/users/blob/master/Docs/Documentation/Installation.md).

2. Install the core by running.

```sh
composer require cakedc/users
```

3. Add the following line to the end of *config/bootstrap.php*, this bootstraps the plugin to application start up.
```php
Plugin::load('CakeDC/Users', ['routes' => true, 'bootstrap' => true]);
```

4. Use [the migrations plugin](https://book.cakephp.org/3.0/en/migrations.html) to install the required tables.

```sh
bin/cake migrations migrate -p CakeDC/Users
```
5. [</> code](https://github.com/stack-x/cake.example.com) Commit your changes with a message of *Added CakeDC's user plugin*.

6. Set the mail transport to debug on line 196 of *config/app.php*
```php 
'className' => 'Debug',
```

7. Navigate to [http://loc.cake.example.com/users/users/login](http://loc.cake.example.com/users/users/login) and have a look around. Use the navigation links to find the registration page and create an account.

8. Notice you will not be able to log in, this is because you have not yet clicked the authorization link out of your email. The local server cannot send emails so you will have manually flip that switch in the database.

9. Login to PhpMyAdmin, find your user record in the cake_app database and flip the active and superuser flags to 1.

10. Now return to the login page and try to log in. On success, you will be redirected to the CakePHP debug page.


### Posts CRUD
We will keep our blog posts in a table called posts.

#### Add the Database Tables

* Login to phpMyAdmin [https://localhost/phpmyadmin](https://localhost/phpmyadmin)
* Click into cake > cake_app from the sidebar
* Click on the SQL tab
* Copy and Paste the following the text area and hit submit
* Repeat this process for cake > cake_test

```sql
-- First, create our posts table: 
CREATE TABLE posts (
    id CHAR(36) PRIMARY KEY COMMENT 'Primary Key UUID',
    title VARCHAR(255) COMMENT 'Title of a blog post',
    slug VARCHAR(255) COMMENT 'An SEO and human-friendly lookup key',
    meta_keywords VARCHAR(255) COMMENT 'Metadata for SEO',
    meta_description VARCHAR(255) COMMENT 'Metadata for SEO',
    body TEXT COMMENT 'The comment of the blog post',
    user_id CHAR(36) COMMENT 'The creator of the blog post',
    created DATETIME DEFAULT CURRENT_TIMESTAMP COMMENT 'Timestamp of creation',
    modified DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Timestamp of last modification' 
) ENGINE=INNODB;


-- Then insert some posts for testing: 
-- You will want to replace USER-ID with the id ofa user from your users table.
INSERT INTO posts (id,title,slug,body,user_id)
    VALUES (UUID(), 'The Title', 'the-title', 'This is the article body.', 'USER-ID');
INSERT INTO posts (id,title,slug,body,user_id)
    VALUES (UUID(), 'Hello World', 'hello-world', 'This is the article body again.', 'USER-ID');
INSERT INTO posts (id,title,slug,body,user_id)
    VALUES (UUID(), 'Hello World Again', 'hello-world-again', 'This is the article body again and again.', 'USER-ID');
```

#### Bake the Model
Since we have the table in our database we can automate the build by *baking* the CRUD (model, views, and controllers). Run the following command and take note of what files get created. In addition to creating an Entity and a Table classes, fixtures and tests will be created, this will provide a placeholder for building unit tests. 

```sh
bin/cake bake model Posts
```

Navigate to the *src/Model* and check out the files in *Entity* and *Article* folders.

##### Unit Tests

[</> Code](https://github.com/stack-x/cake.example.com/commit/8b1fc8724e411ec254ae7f5c5e71f36540d4059f) Start by installing PHP unit
```sh
composer require --dev phpunit/phpunit:"^5.7|^6.0"
```

Run a unit test for each table
```sh
vendor/bin/phpunit tests/TestCase/Model/Table/PostsTableTest
```

Navigate to the *tests/TestCase/Model/Table* walk through the default test cases.

#### Bake the Controller

```sh
bin/cake bake controller Posts
```

#### Bake the Template

```sh
bin/cake bake template Posts
```


### From Basic CRUD to an App

Add an initialization method to the Posts controller
```php
public function initialize()
{
    parent::initialize();
}
```

### Create Slugs in the Background

We will move our slug creation logic from the Posts controller to the Posts table. Here we will use a callback to create slugs in the background. We will create a unit test to verify our slug creation logic.

Call the namespace for the Utility class.
*src/Model/Table/PostsTable.php*
```php
// the Text class
use Cake\Utility\Text;
```

Create the method for creating a slug.
*src/Model/Table/PostsTable.php*
```php
public function createSlug($title)
{
    return Text::slug(
        strtolower(
            substr($title, 0, 191)
        )
    );
}
```

Add and run a unit test for the create slug method.
*tests/TestCase/Model/Table/PostsTableTest.php*
```php
public function testCreateSlug()
{
    $result = $this->Posts->createSlug('Hello World');
    $this->assertEquals('hello-world', $result);
    $result = $this->Posts->createSlug('Hello!, World');
    $this->assertEquals('hello-world', $result);
    $result = $this->Posts->createSlug('Hello   World*$');
    $this->assertEquals('hello-world', $result);
    $result = $this->Posts->createSlug('Hello-   World-');
    $this->assertEquals('hello-world', $result);
}
```

Rerun the unit test
```sh
vendor/bin/phpunit tests/TestCase/Model/Table/PostsTableTest
```

Call ```createSlug()``` from the ```beforeMarshal()``` callback.
*src/Model/Table/PostsTable.php*
```php
public function beforeMarshal($event, $data)
{
    if (!isset($data['slug']) && !empty($data['title'])) {
        $data['slug'] = $this->createSlug($data['title']);
    }
}
```

Test before marshal by creating a new record
*tests/TestCase/Model/Table/PostsTableTest.php*
```sh
public function  testBeforeMarshal()
{
    $article = $this->Posts->newEntity();
    $article = $this->Posts->patchEntity($article, ['title'=>'Hello World, It\'s a fine day']);
    $this->Posts->save($article);

    $result = $this->Posts->find()->first();
    $this->assertEquals('hello-world-it-s-a-fine-day', $result['slug']);
}
```

Rerun the unit test
```sh
vendor/bin/phpunit tests/TestCase/Model/Table/PostsTableTest
```

### Add User Authentication
[</> code](https://github.com/stack-x/cake.example.com/commit/9d8a65128621e75f8f17c95925ad27219e5b786b) Add an instance variable to hold the session object, set this variable during initialization. The following reads as "set this instance of ```$session``` to the session object from this instance of the request object." This will provide a short hand for accessing the session data in controllers.

*src/Controller/AppController.php*
```php
    protected $session;

    public function initialize()
    {
        ...
        $this->session = $this->getRequest()->getSession();
    }
```

#### Deny Aceess by Default
[</> code](https://github.com/stack-x/cake.example.com/commit/44f8149e1b6dda45d8ffa37f13f4b9d8852dafc3)
*src/Controller/AppController.php*
```php
public function initialize()
{
    parent::initialize();

    // Load the AUTH component
    $this->loadComponent('Auth');

    $this->loadComponent('RequestHandler');
    $this->loadComponent('Flash');
    $this->session = $this->getRequest()->getSession();

    // Deny unauthorized access by default
    $this->Auth->deny();
}
```

At this point when you try to access [http://loc.cake.example.com](http://loc.cake.example.com) the application will try to redirect you to *users/login*. This will error out due to us (a) not having a UsersController at the top level and (b) not having a route that directs us to the CakeDC plugin. We will resolve this by adding a route.

[</> code](https://github.com/stack-x/cake.example.com/commit/b32d232a8f74ff1e9512b0cb8c10e9afe332a977) Add the following at line 80 of *src/config/routes.php*

```php

Router::connect(
    '/users/login',
    [
        'plugin' => 'CakeDC/Users',
        'controller' => 'Users',
        'action' => 'login'
    ]
);

```

Now accessing [http://loc.cake.example.com](http://loc.cake.example.com) will redirect you to a login page.



### [Configuration](https://github.com/CakeDC/users/blob/master/Docs/Documentation/Configuration.md)

Navigate to [http://loc.cake.example.com/users/users](http://loc.cake.example.com/users/users) and create a user account.

## Labs

### Lab 1 - Composer

Using the documentation for the users plugin, add the ability to log in using a social media platform of your choice.

### Lab 2 - Comment System

1. Create a table
  * id - the primary key of the comment system
  * post_id - the id of the article for which the comment is being made
  * first_name - the first name of the reader making a comment
  * last_name - the last name of the reader making a comment
  * email - the email of the reader making a comment
  * comment - the reader's comment
  * created - current timestamp at the time of submission
1. At the bottom of each article provide a form that will collect the above data and on submit
  * Save the data to the comments table

### Lab 3 - Contact Form

1. Create a contact form.
1. When a user submits the form, save the contents to a database.
1. When the user submits the form, use the MailGun API to send your self an email every time someone submits the contact form.

## Additional Resources
* [CakePHP](https://cakephp.org/)

[Next: MongoDB](/12-MongoDB/README.md)
