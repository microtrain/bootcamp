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
