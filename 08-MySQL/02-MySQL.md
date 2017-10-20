# MySQL

[MySQL](https://www.mysql.com/) is a free and open source [relational database management system](https://en.wikipedia.org/wiki/Relational_database_management_system) (RDBMS) currently under the control of Oracle. An RDBMS will store data a container called a table. This data is organized by rows and columns similar to a spreadsheet (aka tabular data). Relationships are joined by creating foreign key relationships between rows of data across multiple tables. MySQL uses Structured Query Language (SQL) to retrieve data from tables.

Much like SQL Server, Oracle or PostgreSQL, MySQL is client-server software. This means the database and database management software is running on a server. Even if your running a local instance of MySQL, your running a server. The client is the software you interact with. When you interact with the software, the software makes a request to the server on your behalf. Some common clients are the [MySQL CLI](https://dev.mysql.com/doc/refman/5.7/en/mysql.html), [phpMyAdmin](https://www.phpmyadmin.net/) and [MySQL Workbench](https://www.mysql.com/products/workbench/). Even programming languages act as clients; for example PHP uses the [PDO library](http://php.net/manual/en/book.pdo.php) to interact with a DBMS. [ORMs](https://en.wikipedia.org/wiki/Object-relational_mapping) are another type of client package; an example of this would be [Doctrine](http://www.doctrine-project.org/projects/orm.html) for PHP.

## Additional Reading
* [PDO Library](http://php.net/manual/en/book.pdo.php)
* [MySQL for NodeJS](https://www.npmjs.com/package/mysql)
* [MySQL Client Programs](https://dev.mysql.com/doc/refman/5.7/en/programs-client.html)
* [ORM Is an Offensive Anti-Pattern](http://www.yegor256.com/2014/12/01/orm-offensive-anti-pattern.html)
* [To ORM or Not to ORM](https://www.reddit.com/r/PHP/comments/164r3w/to_orm_or_not_to_orm/)
* [ORM Hate](https://martinfowler.com/bliki/OrmHate.html)

[Next: Working with MySQL](03-WorkingWithMySQL.md)
