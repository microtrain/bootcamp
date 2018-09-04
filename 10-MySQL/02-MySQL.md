# MySQL

[MySQL](https://www.mysql.com/) is a free and open source [relational database management system](https://en.wikipedia.org/wiki/Relational_database_management_system) (RDBMS) currently under the control of Oracle. An RDBMS will store data a container called a table. This data is organized by rows and columns similar to a spreadsheet (aka tabular data). Relationships are joined by creating foreign key relationships between rows of data across multiple tables. MySQL uses Structured Query Language (SQL) to retrieve data from tables.

Much like SQL Server, Oracle or PostgreSQL, MySQL is client-server software. This means the database and database management software is running on a server. Even if your running a local instance of MySQL, your running a server. The client is the software you interact with. When you interact with the software, the software makes a request to the server on your behalf. Some common clients are the [MySQL CLI](https://dev.mysql.com/doc/refman/5.7/en/mysql.html), [phpMyAdmin](https://www.phpmyadmin.net/) and [MySQL Workbench](https://www.mysql.com/products/workbench/). Even programming languages act as clients; for example PHP uses the [PDO library](http://php.net/manual/en/book.pdo.php) to interact with a DBMS. [ORMs](https://en.wikipedia.org/wiki/Object-relational_mapping) are another type of client package; an example of this would be [Doctrine](http://www.doctrine-project.org/projects/orm.html) for PHP.

## Core Concepts of an RDBMS

### Table Structure

A data base is made up of tables which are defined by columns, rows, data types and values. Conceptually you can think of a table in the same way you think of a spreadsheet.

My customers table might look like the following.

![Table Structure](/img/mysql/table.png)


### Keys and Indicies

#### Index
An index provides a faster means of lookup for an SQL query. A good rule of thumb is to create an index for every column that appears in a WHERE clause. You should not create an index for a column that is not used for looking up data.

#### Primary Key (Unique Index)
A primary key in MySQL is both an index and a unique identifier for a given column. Typcially an aut-incrementing integer or a [UUID](https://en.wikipedia.org/wiki/Universally_unique_identifier). In the above example the id column would be my primary key.

#### Forgien Key (Index)

This is a column that links one table to another. For example if I have an address table that I want to link to my customers table I would add a column called customer_id and the value of this column would match an id in the customers table. In this case customer_id is said to be a forgien_key.

#### Unique Keys (Unique Index)

This is an indexed column that requires a unique value for every row in the table.

#### Composite Keys (Unique Index)

This is an indexed key pair that can uniquely identify a row in the table.

#### FullText Index (Unique Index)

This is a special type of index that allows various configurations string searches against rows containing large amounts of text.

### Relationships

#### One-to-one

Table A may (or must) have one and only one corresponding rows in table B.

#### One-to-many

Table A may (or must) have one or more corresponding rows in table B.

#### Many-to-many

Table A may (or must) have one or more corresponding rows in table B and table B may (or must) have one or more corresponding rows in table A. A many-to-many relationship must be resolved by an associative entity. An associative entity is table that links two or more tables togeather using foreign keys.


## Additional Resources
* [PDO Library](http://php.net/manual/en/book.pdo.php)
* [MySQL for NodeJS](https://www.npmjs.com/package/mysql)
* [MySQL Client Programs](https://dev.mysql.com/doc/refman/5.7/en/programs-client.html)
* [ORM Is an Offensive Anti-Pattern](http://www.yegor256.com/2014/12/01/orm-offensive-anti-pattern.html)
* [To ORM or Not to ORM](https://www.reddit.com/r/PHP/comments/164r3w/to_orm_or_not_to_orm/)
* [ORM Hate](https://martinfowler.com/bliki/OrmHate.html)

### Udemy
* [MySQL Courses](https://microtrain.udemy.com/organization/search/?src=ukw&q=mysql)

[Next: Working with MySQL](03-WorkingWithMySQL.md)
