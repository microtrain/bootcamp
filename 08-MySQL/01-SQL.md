# SQL
Structure Query Language (SQL) is language designed specifically for working with databases. SQL is an open standard maintained by the American National Standards Institute (ANSI). Despite being an actively maintained open standard you'll most likely alot of time working with vendor specific variants. These differences are typically subtle and quick Google search will typically get you around them. For instance if you're used to working with Oracle's ```TO_DATE()``` and now you're working with MySQL; ```TO_DATE()``` will not work. Google somthing like _TO_DATE in mysql_ and one of the first results will liekly point to MySQL's ```STR_TO_DATE()``` method. Point being, learning any vendor variant of SQL will be enough to allow you to work with just about any vendor variant. The same Google tricks can even be used for NoSQL databases which we will learn about later. Knowledge of SQL is desired in many industries outside of tech as it is considered to be the _English_ of the data world. Understanding SQL helps you understand other data paradigms such as _noSQL_.

## Database
Not to be confused with a Database Management System (DBMS) is a container. This may be a file or a set files, it really doesn't matter as you will likely never see the data. You will be working exclusively with the DBMS. The DBMS is the software that works with the database. For example products such as Oracle, MySQL, SQL Server and even MongoDB are all database management systems. The first three are also known as a Relation Database management System (RDBMS) while the latter is a NoSQL DBMS.

## Schema
Schema is defined as _a representation of a plan or theory in the form of an outline or model_. Unfortunately, the terms database and schema are often used interchangeably. For our purposes _schema_ will be used to describe a database. This may be a visualization  or the actual SQL file that contains the build commands for the database.

## Tables

A table is a structured list of data typically designed to represent a collection like items. These collections may be users, customers, products, etc. Naming your tables, especially in larger project can prove difficult; defining a [style guide](http://www.sqlstyle.guide/) and sticking to it can save you some headaches in the long run. Once common rule is for all tables to end in a plural form of the entity it represents.

## Columns
A column is often refereed to as a field. A column has several attributes a name, data type, default value and indices are typically what you'll be concerned with. The data type itself may have additional parameters such a length.

Column names should be short and two the point. While style guides vary typical rules state a column name should differ from that of the table and must not over lap with any [reserved words](https://dev.mysql.com/doc/refman/5.7/en/keywords.html).

[Data types](https://dev.mysql.com/doc/refman/5.7/en/data-types.html) cast restraints on a column. For example a column of type integer (INT) would not allow any non-numeric characters. A VARCAHR(10) would allow any combination of characters but will truncate the string after 10 characters.

Default values define what is to be entered if no value is present. This may be null or not null (which will force a value) or any other value compatible with the data type.

[Indicies](https://dev.mysql.com/doc/refman/5.7/en/mysql-indexes.html) are used to improve performance. These take specific columns from a table or tables and stores them in a way that allows them to be looked up quickly with out needing to reanalyze all of the content of all tables involved in the query. I have seen good good indexing literally cut minutes of page load times. While not required all tables should have a primary key.

A primary key is unique index for a row of data. The most common primary key is a simple id. This can be an [auto-incrementing](https://dev.mysql.com/doc/refman/5.7/en/example-auto-increment.html) number, a universally unique identifier [(UUID)](https://en.wikipedia.org/wiki/Universally_unique_identifier) or any other bit of unique data such an email address.

__Security Checkpoint__

_I have seen a number of systems that ask for sensitive data such as social security or employer identification numbers simply because that is the only way they could think of not to risk duplicate data. Think twice before doing this, if your business does not absolutely require this sort of information do not even think about storing it. If it is required, please consult a security professional._

## Additional Resources
* [NoSQL Not Only SQL](http://searchdatamanagement.techtarget.com/definition/NoSQL-Not-Only-SQL)
* [Naming Conventions: Stack Overflow Discussion](https://stackoverflow.com/questions/7662/database-table-and-column-naming-conventions)
* [Integer Types](https://dev.mysql.com/doc/refman/5.7/en/integer-types.html)
###
https://microtrain.udemy.com/sql-for-beginners-course/

[Next: MySQL](02-MySQL.md)
