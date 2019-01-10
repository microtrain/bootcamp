# Working with MySQL


## Making a Connection

Before you can work with MySQL you need to make a connection; we will start with the CLI. If you followed the setup instructions in section 01-04 you should have a local instance of the DBMS running with the credentials of root:password and this will be running on localhost

```sh
mysql -u root -p -h localhost
```
* ```mysql``` - invokes the MySQL CLI
* ```-u root``` - _-u_ is the user argument _-u root_ says login to MySQL as the user root
* ```-p``` - _-p_ is the password argument. You do not want the enter the password here, so this tells the client to prompt you for a password.
* ```-h``` - _-h_ host; locally this will be localhost a remote connection would likely be an IP address or a URL.

As you may have guessed; by entering the aforementioned command you will be prompted a password.
![Connecting](/img/mysql/connect.png)

Upon connection you will be presented with a MySQL prompt.
![Connected](/img/mysql/connected.png)

At the prompt the following command to get a list of databases.
```sql
show databases;
```

You will see something similar to the following. By default MySQL installs a few system databases that it uses for it's own purposes. It is unlikely you ever need to access these yourselves. Just be sure not to delete them.
```sh
+----------------------+
| Database             |
+----------------------+
| information_schema   |
| mysql                |
| performance_schema   |
+----------------------+
3 rows in set (0.03 sec)
```

Now let's create a databases.
```sql
CREATE DATABASE bootcamp;
```

You should get something similar to the following response. What you are really looking for is an affected row count.
```sh
Query OK, 1 row affected (0.00 sec)
```

Now verify the database has been created. Run the following command and you will see _bootcamp_ in the list of databases.
```sql
SHOW DATABASES;
```

Now lets use our new database.
```sql
USE bootcamp;
SHOW TABLES;
```

_show tables;_ shows a list of tables from the current database. After running this command the DBMS should respond with _Empty set (0.00 sec)_.

Let's say we were going to build our own blogging software in the form of a web application. We will start by gathering some requirements.
* As a blogger I need to be able to create blog posts.
* As a web site owner I need to assure that only authorized people can post to the blog.

From a data perspective the first item can be achieved with a table named _users_ the second with a table named _posts_.

Tables are created using the _CREATE TABLE_ command. ```CREATE TABLE _tablename_()``` where _tablename_ is the name of the table to be created. The columns in your table are passed into the parentheses as comma separated values.

Add the following table to your bootcamp database.

```sql
CREATE TABLE users (
    id VARCHAR(36) PRIMARY KEY COMMENT 'Primary Key UUID',
    first_name VARCHAR(40) DEFAULT NULL COMMENT 'The users first name',
    last_name VARCHAR(40) DEFAULT NULL COMMENT 'The users last name',
    email VARCHAR(200) DEFAULT NULL COMMENT 'A unique identifier for a user',
    created DATETIME DEFAULT CURRENT_TIMESTAMP COMMENT 'When the user was created',
    modified DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'When the user was last edited'
) ENGINE=INNODB;
```

We already talked about _CREATE TABLE_ now lets look at the columns definitions. _id VARCHAR(36) PRIMARY KEY COMMENT 'Primary Key UUID'_

* id - This is the name of the column. Most tables will have an id column.
* VARCHAR(36) - This allows any character on the keyboard but caps the length at 36 characters. This is usually indicative of a UUID or GUID.
* PRIMARY KEY - Every table SHOULD have a primary id. This serves as a unique index for that table.
* COMMENT 'Primary Key UUID' - A short description about the purpose of this column. In practice I wouldn't comment obvious fields.

Lets jump to the modified column _modified DATETIME DEFAULT CURRENT&#95;TIMESTAMP ON UPDATE CURRENT&#95;TIMESTAMP_

* modified - The name of the column.
* DATETIME - Sets the datatype to a mysql time stamp _YYYY-MM-DD HH:MM:SS_
* DEFAULT CURRENT_TIMESTAMP - When a new row is created the modified column will default to the time of creation.
* ON UPDATE CURRENT_TIMESTAMP - When a new row is created the modified column will change to the time of update.

Now let's create the table for holding our blog posts.

```sql
CREATE TABLE posts (
    id VARCHAR(36) PRIMARY KEY COMMENT 'Primary Key UUID',
    title VARCHAR(255) COMMENT 'The title of the blog post',
    slug VARCHAR(255) COMMENT 'A human and SEO friendly lookup key',
    meta_keywords VARCHAR(255) COMMENT 'Meta data for SEO',
    meta_description VARCHAR(255) COMMENT 'Meta data for SEO',
    body TEXT COMMENT 'The content of the blog post',
    user_id VARCHAR(36) COMMENT 'The creator of the blog post',
    created DATETIME DEFAULT CURRENT_TIMESTAMP COMMENT 'When the post was created',
    modified DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'When the post was last edited'
) ENGINE=INNODB;
```

Now let's take a look at our data structure.

```sql
USE bootcamp;
SHOW TABLES;

SHOW COLUMNS FROM users;
DESCRIBE posts;
```

Now that we have created a couple of tables. Let's add some data. Run the following command from your bootcamp database replacing xxxx with you information.

```sql
INSERT INTO users SET id=UUID(), first_name='xxxx', last_name='xxxx', email='xxxx';
```

Now let's look up your user record.

```sql
SELECT * FROM users WHERE email='xxxx';
```


What if only want a list of names?

_NOTE: As queries get longer this style may be easier to read._

```sql
SELECT
  first_name,
  last_name
FROM
  users
WHERE
  email='xxxx';
```

Id rather see the user's name in a single column formatted as _last, first_
```sql
SELECT
  CONCAT('last_name', ', ', first_name) AS user
FROM
  users
WHERE
  email='xxxx';
```

Add another user.
```sql
INSERT INTO
  users
SET
  id=UUID(),
  first_name='Bob',
  last_name='Smith',
  email='bsmith@exampl.com';
```

Let's find all users with a _.com_ and sort in ascending order by last name.
```sql
SELECT
  CONCAT('last_name', ' ', first_name) AS user
FROM
  users
WHERE
  email LIKE '%.com'
ORDER BY last_name ASC;
```

```sql
INSERT INTO 
  posts 
SET 
  id=UUID(), 
  slug='hello', 
  title='Hello', 
  user_id = '1a804677-7953-11e7-8397-180373ae98cc';

SELECT 
  posts.title,
  CONCAT(first_name, ' ', last_name) AS author
FROM 
  posts, 
  users 
WHERE 
  posts.created_user_id = users.id ;
```

For full authentication you will want to add password and salt columns 
* password VARCHAR(60) COMMENT 'A salted hash of the password'
* salt VARCHAR(128) COMMENT 'User specific salt'

```sql
ALTER TABLE users
  ADD COLUMN password VARCHAR(60) DEFAULT NULL COMMENT 'A salted hash of the password',
  ADD COLUMN salt VARCHAR(128) DEFAULT NULL  COMMENT 'User specific salt';
```

>**Security Checkpoint**  
>Never store a password in plain text, always store a hashed version of the password. Always create a user specific salt this will protect against [rainbow table attacks](https://en.wikipedia.org/wiki/Rainbow_table).

## Additional Resources
* [Safe Password Hashing](http://php.net/manual/en/faq.passwords.php)
* [Rainbow Tables](https://en.wikipedia.org/wiki/Rainbow_table)

[Next: DataModels](04-DataModels.md)


