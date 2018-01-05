# CakePHP

CakePHP is and MVC (Model, View Controller) based rapid application development (RAD) framework built using PHP. CakePHP has a solid eco-system and is designed around test driven development (TDD).

## Installation
First make sure you have installed internationalization functions for PHP.
```sh
sudo apt-get install php-intl

```

Create a CakePHP project via composer. Sticking with the _example.com_ nomenclature we will call this one _cake.example.com_.
```sh
cd /var/www
composer create-project --prefer-dist cakephp/app cake.example.com
```

Answer yes to the following
```
Set Folder Permissions ? (Default to Y) [Y,n]?
```

## Your First App
Move into the new project folder
```
cd cake.example.com
```

Spin up a development web server.
```
bin/cake server
```

and in a browser go to  [http://localhost:8765/](http://localhost:8765/). You will be presented a default home page that shows that gives you plenty of resources to help you learn CakePHP and it will return a system status that makes sure you system is set up correctly. Everything should be green except for the database.

![default home page](/img/cakephp/default_home.png)

Add *cake.example.com* as a project in Atom. Navigate to *config/app.php* this is the default configuration file for your application. CakePHP stores it configuration as an array, find the _Datasources_ attribute somewhere arounf the the line _220_ (you can use the shortcut [ctrl] + [g] and enter _220_). You will notice two child attributes _default_ and _test_. _default_ holds the configuration for your application's database while test holds the configuration for running unit tests.

### Setup Your Database

Go to [http://localhost/phpmyadmin](http://localhost/phpmyadmin) and login as with _root:password_. Find the Databases tab and under the _Create database_ header enter _cake_app_ as your first database. This will now ask you to create a table, skip this step and find your way back to the Databases tab and create another database called _cake_test_ you can now close out of phpMyAdmin and return to the _app.php_ file in Atom.

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

Let's set up an Apache configuration with a local hosts entry for development purposes.
````sh
sudo vim /etc/apache2/sites-available/cake.example.com.conf
````
```apache
<VirtualHost 127.0.0.32:80>

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

Add the following to */etc/hosts*

```sh
127.0.0.32      loc.cake.example.com
```

and finally load the new site.
```sh
sudo a2ensite cake.example.com && sudo service apache2 restart
```

Should you encounter any write permission issues
```sh
sudo chown www-data:jason logs
sudo chown www-data:jason logs/*
sudo chown www-data:jason tmp
sudo chown www-data:jason tmp/*
```

@todo navigate to src, explain the directory structure Model, Views and Controller
@todo callback methods and lifcycles as it pertains a CakePHP and Programming in general.

## [Blog Tutorial](https://book.cakephp.org/3.0/en/tutorials-and-examples/blog/blog.html)

We will start by using the blog tutorial from CakePHP's documentation to build a CMS for creating blog posts. We then use Composer to install a user [Authentication plugin](https://github.com/CakeDC/users). Then we will then tie Users to Articles (a blog post).

* Login to phpMyAdmin
* Click into cake > cake_app from the side bar
* Click on the SQL tab
* Copy and Paste the following the text area and hit submit
* Repeat this process for cake > cake_test

```sql
/* First, create our articles table: */
CREATE TABLE articles (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(50),
    body TEXT,
    created DATETIME DEFAULT NULL,
    modified DATETIME DEFAULT NULL
);

/* Then insert some articles for testing: */
INSERT INTO articles (title,body,created)
    VALUES ('The title', 'This is the article body.', NOW());
INSERT INTO articles (title,body,created)
    VALUES ('A title once again', 'And the article body follows.', NOW());
INSERT INTO articles (title,body,created)
    VALUES ('Title strikes back', 'This is really exciting! Not.', NOW());
```

Since we have the table in our database we can automate the build by *baking* the model. Run the following command and take note of what files get created.
```sh
bin/cake bake model Articles
```

You'll notice fixtures and tests are created, this provide a placeholder for building unit tests.

Navigate to the *src/Model* and check out the files in *Entity* and *Article* folders.

## Users

We will install the users plugin developed by CakeDC. The documentation is available [here](https://github.com/CakeDC/users/blob/master/Docs/Documentation/Installation.md).

Install the core by running
```sh
cd /var/www/cake.example.com
composer require cakedc/users
```

Use migrations to install the required tables.
```sh
bin/cake migrations migrate -p CakeDC/Users
```

Add the following line to the end of *config/bootstrap.php*, this bootstraps the plugin to application start up.
```php
Plugin::load('CakeDC/Users', ['routes' => true, 'bootstrap' => true]);
```

### [Configuration](https://github.com/CakeDC/users/blob/master/Docs/Documentation/Configuration.md)


Navigate to [http://loc.cake.example.com/users/users](http://loc.cake.example.com/users/users) and create a user account.

Create a custom MailTransport for MailGun

## Tie Users to Articles

Add a column called user_id to the articles table.

## Lab

Using the documentation for the users plugin add the ability to login using a social media platform of your choice.

## Additional Resources
* [CakePHP](https://cakephp.org/)
