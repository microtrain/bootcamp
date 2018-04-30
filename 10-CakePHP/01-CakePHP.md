# CakePHP

CakePHP is and MVC (Model, View, Controller) based rapid application development (RAD) framework built using PHP. CakePHP has a solid eco-system and is designed around test driven development (TDD).

## MVC

MVC is a software design patter that splits your application into three distinct layers data (Model), Business Logic (Controller), and presentation (View).

### Model

A model can be anything that provides data such a table in a database, a reference to an API, a spreed sheet, etc. For our user a model will reference a table in a database.

### View

View's are the presentation layer. Views will typically be HTML but can be anything a client can read such as .html, .json, .xml, .pdf or even a header that only a machine can access.

### Controller

Business and application logic.

## CRUD

Create, Read, Update, Delete

## Migrations
Rolling snapshots of the database structure. These allow you migrate your database's strucutre forward and backwards across snapshots.

## Create a Repository on GitHub

* Create the  repository *cake.example.com*.
* **DO NOT** Initialize with a README
* Add the MIT License

[</> code](https://github.com/stack-x/cake.example.com/commits/master) Initial Commit

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

In a browser go to [http://localhost:8765/](http://localhost:8765/). You will be presented a default home page that shows that gives you plenty of resources to help you learn CakePHP and it will return a system status that makes sure you system is set up correctly. Everything should be green except for the database.

![default home page](/img/cakephp/default_home.png)

Add *cake.example.com* as a project in Atom. Navigate to *config/app.php* this is the default configuration file for your application. CakePHP stores it configuration as an array, find the *Datasources* attribute somewhere arounf the the line *220* (you can use the shortcut [ctrl] + [g] and enter *220*). You will notice two child attributes *default* and *test*. *default* holds the configuration for your application's database while test holds the configuration for running unit tests.

### Setup Your Database

We will use PhpMyAdmin to create two databases
* cake_app
* cake_test

Go to [http://localhost/phpmyadmin](http://localhost/phpmyadmin) and login as with _root:password_. Find the Databases tab and under the _Create database_ header enter *cake_app* as your first database. This will now ask you to create a table, skip this step and find your way back to the Databases tab and create another database called *cake_test* you can now close out of phpMyAdmin and return to the _app.php_ file in Atom.

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

Let's set up an Apache configuration with a local hosts entry for development purposes.

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

Add the following to */etc/hosts*

```sh
127.0.0.101      loc.cake.example.com
```

and finally load the new site.
```sh
sudo a2ensite cake.example.com && sudo service apache2 restart
```

Navigate to [http://loc.cake.example.com/](http://loc.cake.example.com/) and you should encounter write permission issues. Resolve this by changing ownership of these files to the Apache process (www-data) and Yourself (replace jason with your Ubuntu username).
```sh
sudo chown www-data:jason logs
sudo chown www-data:jason logs/*
sudo chown www-data:jason tmp
sudo chown www-data:jason tmp/*
sudo chown www-data:jason tmp/*/*
```

Return to [http://loc.cake.example.com/](http://loc.cake.example.com/) and all systems should now be a go.

### Merge with the Exisiting GitHub Project

[</> Code](https://github.com/stack-x/cake.example.com/commit/5206abb675ad8decf9664a543e2d3022c42a17f5) Run the following commands, be sure to replace YOUR-GITHUB-USERNAME with your github username.

```sh
cd /var/www/cake.example.com
git init
git remote add origin git@github.com:YOUR-GITHUB-USERNAME/cake.example.com.git
git pull origin master
git add .
git commit -am 'Initial build'
```


### Cake File Structure, Callbacks and Routing

@todo navigate to src, explain the directory structure Model, Views and Controller
@todo callback methods and lifcycles as it pertains a CakePHP and Programming in general.


## [Blog Tutorial](https://book.cakephp.org/3.0/en/tutorials-and-examples/blog/blog.html)

We will start by using Composer to install CakeDC's [User Authentication plugin](https://github.com/CakeDC/users). We will then build an Articles CRUD based on CakePHP's [CMS tutorial](https://book.cakephp.org/3.0/en/tutorials-and-examples/blog/blog.html). We will then tie Users to Articles (a blog post). Our lad will apply everything we just learned to building a comment system for our blogging platform. In you console, please navigate to **/var/www/cake.example.com**, this tutorial assumes **/var/www/cake.example.com** as the base path for all cd, file and folder creation commands.

### Users

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


6. Remove deprication warnings from line 168 of *config/app.php*
```php
'errorLevel'=>'E_ALL & ~E_USER_DEPRECATED',
```

7. Set the mail transport to debug on line 196 of *config/app.php*
```php 
'className' => 'Debug',
```

8. Navigate to [http://loc.cake.example.com/users/users/login](http://loc.cake.example.com/users/users/login) and have a look around. Use the navigation links to find the registration page and create an account.

9. Notice you will not be able to login, this is because you have not yet clicked the autorization link out of your email. THe local server cannot send emails so you will have manually flip that switch in the database.

10. Login to PhpMyAdmin, find your user record in the cake_app database and flip the active and superuser flags to 1.

11. Now return to the login page and try to login. On success you will be redirected to the CakePHP debuggin page.


## Add the Database Tables

* Login to phpMyAdmin [https://localhost/phpmyadmin](https://localhost/phpmyadmin)
* Click into cake > cake_app from the side bar
* Click on the SQL tab
* Copy and Paste the following the text area and hit submit
* Repeat this process for cake > cake_test

```sql
-- First, create our articles table: 
CREATE TABLE articles (
    id VARCHAR(36) PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(191) NOT NULL,
    body TEXT,
    published BOOLEAN DEFAULT FALSE,
    created DATETIME DEFAULT CURRENT_TIMESTAMP COMMENT 'When the post was created',
    modified DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'When the post was last edited',
    UNIQUE KEY (slug),
    KEY (user_id)
) ENGINE=INNODB;


-- Then insert some articles for testing: 
INSERT INTO articles (id,user_id,title,slug,body)
    VALUES ('6f814dc0-4adb-11e8-842f-0ed5f89f718b', 'The Title', 'the-title', 'This is the article body.');
INSERT INTO articles (id,user_id,title,slug,body)
    VALUES ('6f8155ae-4adb-11e8-842f-0ed5f89f718b', 'Hello World', 'hello-world', 'This is the article body again.');
INSERT INTO articles (id,user_id,title,slug,body)
    VALUES ('6f815964-4adb-11e8-842f-0ed5f89f718b', 'Hello World Again', 'hello-world-again', 'This is the article body again and again.');
```

[</> Code](https://github.com/stack-x/cake.example.com/commit/ea597581218496f1aec5f748b29ebe4d463853f5) Since we have the table in our database we can automate the build by *baking* the model. Run the following command and take note of what files get created. In addition to creating an Entity and a Table classes, fixtures and tests will be created, thie will provide a placeholder for building unit tests. 

```sh
bin/cake bake model Articles
```

Navigate to the *src/Model* and check out the files in *Entity* and *Article* folders.

### Unit Test

[</> Code](https://github.com/stack-x/cake.example.com/commit/8b1fc8724e411ec254ae7f5c5e71f36540d4059f) Start by installing PHP unit
```sh
composer require --dev phpunit/phpunit:"^5.7|^6.0"
```

Run a unit test for each table
```sh
vendor/bin/phpunit tests/TestCase/Model/Table/ArticlesTableTest
```

Navigate to the *tests/TestCase/Model/Table* walk through the default test cases.


## Managing Articles

[</> code](https://github.com/stack-x/cake.example.com/commit/6ddc78996c51b9982292200782f39c717b1b6684) Create the file */src/Controller/ArticlesController.php* and add the following.
```php
<?php
namespace App\Controller;

class ArticlesController extends AppController
{

}
```

### Add an Index Method

[</> code](https://github.com/stack-x/cake.example.com/commit/ce8594d032d9163017cf5a35c4f930002386970c) The index method will return a paginated list articles and send them a the view.

```php
public function index()
{
    $this->loadComponent('Paginator');
    $articles = $this->Paginator->paginate($this->Articles->find());
    $this->set(compact('articles'));
}
```

#### Add the View

Create the file */src/Template/Articles/index.ctp*

```php
<h1>Articles</h1>
<table>
    <tr>
        <th>Title</th>
        <th>Created</th>
    </tr>

    <?php foreach ($articles as $article): ?>
    <tr>
        <td>
            <?php echo $this->Html->link($article->title, ['action' => 'view', $article->id]); ?>
        </td>
        <td>
            <?php echo $article->created; ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
```


### Add a View Method

[</> code](https://github.com/stack-x/cake.example.com/commit/e43ab2ea483ab73b2dd6d6fab4bbe97ec058478a)

```php
public function view($slug = null)
{
    $article = $this->Articles->findBySlug($slug)->firstOrFail();
    $this->set(compact('article'));
}
```

#### Add the View

Create the file */src/Template/Articles/view.ctp*
```php
<h1><?php echo $article->title; ?></h1>
<div>Created: <?php echo $article->created; ?></div>
<div><?php echo $article->body; ?></div>
<div><?php echo $this->Html->link('Edit', ['action' => 'edit', $article->slug]); ?></div>
```

## Add an Initialize Method

[</> code](https://github.com/stack-x/cake.example.com/commit/28ede2eaa70209340af86fad52b901e6686d9c04) Since the Flash Component will be reused elsewhere we will add an initialization method and add load our components there.

```php
public function initialize()
{
    parent::initialize();

    $this->loadComponent('Flash');
    $this->loadComponent('Paginator');
}
```

### Add an Create Method
[</> code](https://github.com/stack-x/cake.example.com/commit/8b06fc21beb3452e671ef997ba3362e6a6ada7d2)
```php
public function create()
{
    $article = $this->Articles->newEntity();
    if ($this->request->is('post')) {
        $article = $this->Articles->patchEntity($article, $this->request->getData());

        $article->slug = Text::slug(
            strtolower(
                substr($article->title, 0, 191)
            )
        );

        if ($this->Articles->save($article)) {
            $this->Flash->success('Your article has been created.');
            return $this->redirect(['action' => 'index']);
        }

        $this->Flash->error('An error has occured.');
    }
    $this->set('article', $article);
}
```

#### Add the View

Create the file */src/Template/Articles/create.ctp*
```php
<h1>Create an Article</h1>
<?php
    echo $this->Form->create($article);

    echo $this->Form->control('title');
    echo $this->Form->control('body', ['rows' => '5']);
    echo $this->Form->button('Save Article');
    echo $this->Form->end();
```

### Add an Edit Method
[</>code](https://github.com/stack-x/cake.example.com/commit/d30698b9af799fb3afae325f7b8c1c0683cb905c)
```php
public function edit($id = null)
{
    $article = $this->Articles->findBySlug($slug)->firstOrFail();
    if ($this->request->is(['post', 'put'])) {
        $this->Articles->patchEntity($article, $this->request->getData());

        $article->slug = Text::slug(
            strtolower(
                substr($article->title, 0, 191)
            )
        );

        if ($this->Articles->save($article)) {
            $this->Flash->success('Your article has been updated.');
            return $this->redirect(['action' => 'index']);
        }
        $this->Flash->error('An error has occured.');
    }

    $this->set('article', $article);
}
```

<!-- -->

#### Add the View

Create the file */src/Template/Articles/edit.ctp*
```php
echo $this->Form->create($article);
echo $this->Form->control('title');
echo $this->Form->control('body', ['rows' => '5']);
echo $this->Form->button('Update Article');
echo $this->Form->end();
```
### Add a Delete Method
[</> code](https://github.com/stack-x/cake.example.com/commit/d25cafeec10ad53cdd5aecd8bad775546e9dbe4a)
```php
public function delete($id = null)
{
    $this->request->allowMethod(['post', 'delete']);

    $article = $this->Articles->findById($id)->firstOrFail();
    if ($this->Articles->delete($article)) {
        $this->Flash->success("The article: {$article->title} has been deleted.");
        return $this->redirect(['action' => 'index']);
    }
}
```

#### Add the View

Add a delete link to the view template */src/Template/Articles/view.ctp*
```php
<div>
    <?php
        echo $this->Html->link(
            'Edit',
            ['action' => 'edit', $article->id]
        );
        echo '&nbsp;|&nbsp;';
        echo $this->Form->postLink(
            'Delete',
            ['action' => 'delete', $article->id],
            ['confirm' => __('Are you sure, you want to delete {0}?', $article->title)]
        );
    ?>
</div>
```

**NOTE:** The delete does not require a view.

* Auto create slug values

```php
// the Text class
use Cake\Utility\Text;

// Add the following method.

public function beforeSave($event, $entity, $options)
{
    if ($entity->isNew() && !$entity->slug) {
        $sluggedTitle = Text::slug($entity->title);
        // trim slug to maximum length defined in schema
        $entity->slug = substr($sluggedTitle, 0, 191);
    }
}
```

### Tie Users to Articles

Add a column called user_id to the articles table .

```sql

-- Add the user_id column
ALTER TABLE articles ADD user_id VARCHAR(36) AFTER id NOT NULL DEFAULT 0;

 -- Swap out the user_id with YOUR user id from the database
UPDATE articles SET user_id='xxxx'
```

<!--
and create a foreign key relationship to the users table
```sql
ALTER TABLE articles ADD CONSTRAINT user_id FOREIGN KEY (user_id) REFERENCES users(id);
```
-->


### [Configuration](https://github.com/CakeDC/users/blob/master/Docs/Documentation/Configuration.md)

Navigate to [http://loc.cake.example.com/users/users](http://loc.cake.example.com/users/users) and create a user account.

## Labs

### Lab 1 - Composer

Using the documentation for the users plugin add the ability to login using a social media platform of your choice.

### Lab 2 - Comment System

1. Create a table
  * id - the primary key of the comment system
  * article_id - the id of the article for which the comment is being made
  * first_name - the first name of the reader making a comment
  * last_name - the last name of the reader making a comment
  * email - the email of the reader making a comment
  * comment - the readers comment
  * created - current time stamp at the time of submission
1. At the bottom of each article provide a form that will collect the above data and on submit
  * Save the data to the comments table
  * Use the MailGun API to send your self an email telling you someone has commented on your article.

### Lab 3 - Contact Form

1. Create a contact form.
1. When a user submits the form, save the contents to a database.
1. When the user submits the form, use the MailGun API to send your self an email every time someone submits the contact form.

## Additional Resources
* [CakePHP](https://cakephp.org/)
