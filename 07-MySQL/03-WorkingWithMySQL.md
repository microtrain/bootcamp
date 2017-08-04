# Working with MySQL


## Making a Connection

Before you can work with MySQL you need to make a connection; we will start with the CLI. If you followed the setup instructions in section 01-04 you should have a local instance of the DBMS running with the credentials of root:password and this will be running on localhost

````
mysql -u root -p -h localhost
````
* ````mysql```` - invokes the MySQL CLI
* ````-u root```` - _-u_ is the user argument _-u root_ says login to MySQL as the user root
* ````-p```` - _-p_ is the password argument. You do not want the enter the password here, so this tells the client to prompt you for a password.
* ````-h```` - _-h_ host; locally this will be localhost a remote connection would likely be an IP address or a URL.

As you may have guessed; by entering the aforementioned command you will be prompted a password.
![Connecting](/img/mysql/connect.png)

Upon connection you will be presented with a MySQL prompt.
![Connected](/img/mysql/connected.png)

At the prompt the following command to get a list of databases.
````
show databases;
````

You will see something similar to the following. By default MySQL installs a few system databases that it uses for it's own purposes. It is unlikely you ever need to access these yourselves. Just be sure not to delete them.
````
+----------------------+
| Database             |
+----------------------+
| information_schema   |
| mysql                |
| performance_schema   |
+----------------------+
3 rows in set (0.03 sec)
````

Now let's create a databases.
````
create database bootcamp;
````

You should get something similar to the following response. What you are really looking for is an affected row count.
````
Query OK, 1 row affected (0.00 sec)
````

Now verify the database has been created. Run the following command and you will see _bootcamp_ in the list of databases.
````
show databases;
````

Now lets use our new database.
````
use bootcamp;
show tables;
````

_show tables;_ shows a list of tables from the current database. After running this command the DBMS should respond with _Empty set (0.00 sec)_.

Let's say we were going to build our own blogging software in the form of a web application. We will start by gathering some requirements.
* As a blogger I need to be able to create blog posts.
* As a web site owner I need to assure that only authorized people can post to the blog.

From a data perspective the first item can be achieved with a table named _posts_ the second with a table named _users_.

````
CREATE TABLE users (
    id VARCHAR(36) PRIMARY KEY COMMENT 'Primary Key UUID',
    first_name VARCHAR(35) DEFAULT NULL COMMENT 'The users first name',
    last_name VARCHAR(35) DEFAULT NULL COMMENT 'The users last name',
    email VARCHAR(200) DEFAULT NULL COMMENT 'A unique identifies for a user',
    password VARCHAR(60) COMMENT 'A salted hash of the password',
    salt VARCHAR(128) COMMENT 'User specific salt',
    created DATETIME DEFAULT CURRENT_TIMESTAMP COMMENT 'When the post was created',
    modified DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'When the post was last edited'
) ENGINE=INNODB;
````

````
CREATE TABLE posts (
    id VARCHAR(36) PRIMARY KEY COMMENT 'Primary Key UUID',
    title VARCHAR(255) COMMENT 'The title of the blog post',
    slug VARCHAR(255) COMMENT 'A human and SEO friendly lookup key',
    keywords VARCHAR(255) COMMENT 'Meta data for SEO',
    description VARCHAR(255) COMMENT 'Meta data for SEO',
    body TEXT COMMENT 'The content of the blog post',
    created_user_id VARCHAR(36) COMMENT 'The creator of the blog post',
    created DATETIME DEFAULT CURRENT_TIMESTAMP COMMENT 'When the post was created',
    modified_user_id VARCHAR(36) COMMENT 'The last user to edit the post',
    modified DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'When the post was last edited',
    CONSTRAINT created_by FOREIGN KEY (created_user_id)
    REFERENCES users(id),
    CONSTRAINT modified_by FOREIGN KEY (modified_user_id)
    REFERENCES users(id)
) ENGINE=INNODB;
````


INSERT INTO posts SET id=UUID(), slug='hello', title='Hello';
INSERT INTO posts SET id=UUID(), slug='hello', title='Hello', created_user_id = '1a804677-7953-11e7-8397-180373ae98cc', modified_user_id='1a804677-7953-11e7-8397-180373ae98cc';
SELECT * FROM posts, users WHERE posts.created_user_id = users.id ;
