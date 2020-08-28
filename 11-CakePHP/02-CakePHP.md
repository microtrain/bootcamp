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

Update sqlite needed for file system and restart
```
sudo apt install sqlite3 php-sqlite3 -y
sudo phpenmod sqlite3 && sudo systemctl restart apache2
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

Add *cake.example.com* as a project to VSC. Navigate to *config/app.php* this is the default configuration file for your application. CakePHP stores its configuration as an array, find the *Datasources* attribute somewhere around the line *220* (you can use the shortcut [ctrl] + [g] and enter *261*). You will notice two-child attributes *default* and *test*. *default* holds the configuration for your application's database while test holds the configuration for running unit tests.

### Setup Your Database

We will use PhpMyAdmin to create two databases
* cake_app
* cake_test

Go to [http://localhost/phpmyadmin](http://localhost/phpmyadmin) and login as with _root:password_. Find the Databases tab and under the _Create database_ header enter *cake_app* as your first database. This will now ask you to create a table, skip this step and find your way back to the Databases tab and create another database called *cake_test* you can now close out of phpMyAdmin and return to the _app.php_ file in VSC.

![phpMyAdmin](/img/cakephp/createdb.png)

Update the database configurations as follows. _app.php_ _app_local.php_ _app_local.example.php_

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

Return to [http://localhost:8765/](http://localhost:8765/) and refresh the page, all settings should now be green.

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

## Build a Blog

We will start by using Composer to install CakeDC's [User Authentication plugin](https://github.com/CakeDC/users). We will then bake a Posts CRUD which we will use for posting to our blog. In your console, please navigate to **/var/www/cake.example.com**, this tutorial assumes **/var/www/cake.example.com** as the base path for all cd, file and folder creation commands.

### Users

We will start by using Composer to install CakeDC's [User Authentication plugin](https://github.com/CakeDC/users). This will serve as the foundation of our application.

1. We will install the users plugin developed by CakeDC. The documentation is available [here](https://github.com/CakeDC/users/blob/master/Docs/Documentation/Installation.md).

2. Install the core by running.

```sh
composer require cakedc/users
```

3. Add the following under line 58 of *src/Application.php*, this bootstraps the plugin to application start up.
```php
// Load more plugins here
$this->addPlugin(\CakeDC\Users\Plugin::class);
```

4. Use [the migrations plugin](https://book.cakephp.org/4/en/appendices/4-0-migration-guide.html) to install the required tables for *using CakeDC Users plugin* to store your users and social accounts*:

```sh
bin/cake migrations migrate -p CakeDC/Users
```

5. [</> code](https://github.com/stack-x/cake.example.com) Commit your changes with a message of *Added CakeDC user plugin*.

6. Update the mail transport class to debug on line 208 of *config/app.php*
```php 
// turn on for email through server
// 'className' => MailTransport::class,
'className' => 'Debug',
```
7. Navigate to [http://loc.cake.example.com/users/login](http://loc.cake.example.com/users/login) and have a look around. Use the navigation links to find the ``registration page`` and create an account.

8. Notice you will not be able to log in, this is because you have not yet clicked the authorization link out of your email. The local server cannot send emails so you will have manually flip that switch in the database.

9. Login to PhpMyAdmin, find your user record in the cake_app database and flip the `active and superuser flags to 1`.

10. Now return to the login page and try to log in. On success, you will be redirected to the CakePHP debug page.

> ### Troubleshooting 
> If ERROR! Database can't be written repeat `write permission issues` above.

> If registration fails or can't find database users;
> You can create the first user, the super user by issuing the following command
> `bin/cake users addSuperuser`

11. To logout, add Logout at the end of URL [http://loc.example.com/logout](http://loc.cake.example.com/logout)

12. Create 3 unique users, repeat Registration steps 7-11 above.

13. Commit your changes with a message of *Added Cake Users CRUD*.

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

Navigate to the *src/Model* and check out the files in *Entity* and *Table* folders.

#### Bake the Controller

```sh
bin/cake bake controller Posts
```

#### Bake the Template

```sh
bin/cake bake template Posts
```

Navigate to the [*/posts*](http://loc.cake.example.com/posts)


### From Basic CRUD to an App

Add an initialization method to the Posts controller
```php
public function initialize(): void
{
    parent::initialize();
}
```
Commit your changes with a message of *Add POSTS CRUD*


## Exercise 1
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

Remove Slug Create field from Template
*/Posts/add.php*
```php
// echo $this->Form->control('slug');
```

Recreate a new post and run the create slug in background
Submit [New Post](http://loc.cake.example.com/posts)

Commit your changes with a message of *Create Slugs in the Background*

## Exercise 2

### Add Users CRUD
*Bake the Model* ``bin/cake bake model Users``

*Bake the Controller* ``bin/cake bake controller Users``

*Bake the Template* ``bin/cake bake template Users``

Add an initialization method to the Users controller
```
public function initialize():void
{
    parent::initialize();
}
```
Commit your changes with a message of *Add Users CRUD*

## Exercise 3

### Add User Authentication
In CakePHP this is handled by the authentication plugin. Let’s start off by installing it.
```sh
composer require cakephp/authentication:^2.0
```
Then add the following to your application’s bootstrap() method: *src/Application.php* add  to Line 119
```sh
$this->addPlugin('Authentication');
```

Now, on every request, the AuthenticationMiddleware will inspect the request session to look for an authenticated user. If we are loading the /users/login page, it’ll inspect also the posted form data (if any) to extract the credentials. By default the credentials will be extracted from the email and password fields in the request data. The authentication result will be injected in a request attribute named authentication. 
At this point we will want the /login to redirect to Posts. In your *src/Controller/UsersController.php*, add the following code: Line 41
```sh
public function login()
{
    $this->request->allowMethod(['get', 'post']);
    $result = $this->Authentication->getResult();
    // regardless of POST or GET, redirect if user is logged in
    if ($result->isValid()) {
        // redirect to /articles after login success
        $redirect = $this->request->getQuery('redirect', [
            'controller' => 'Posts',
            'action' => 'index',
        ]);

        return $this->redirect($redirect);
    }
    // display error if user submitted and authentication failed
    if ($this->request->is('post') && !$result->isValid()) {
        $this->Flash->error(__('Invalid email or password'));
    }
}
```
Add the logout action to the UsersController class: Line 61
*src/Controller/UsersController.php*

```sh
public function logout()
{
    $result = $this->Authentication->getResult();
    // regardless of POST or GET, redirect if user is logged in
    if ($result->isValid()) {
        $this->Authentication->logout();
        return $this->redirect(['controller' => 'Users', 'action' => 'login']);
    }
}
```
Now you can [/users/logout](http://loc.cake.example.com/users/logout)
You should then be sent to the login page. 

## Exercise 4

### Simple Navigation Change
Change links to point to Posts, Users *templates/layout/default.php* Line 44
```sh
<a href="/posts/">Posts</a>
<a href="/users/">Users</a>
```

## Additional Resources
* [CakePHP](https://cakephp.org/)

[Next: MongoDB](/12-MongoDB/README.md)
