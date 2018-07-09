# [LAMP Stack](https://en.wikipedia.org/wiki/LAMP_(software_bundle))

The LAMP stack (Linux, Apache, MySQL, PHP) is one of the oldest and most mature and popular technology stacks on the web. Ubuntu allows you to install the entire stack with a single command.

```sh
sudo apt install lamp-server^
```

**DO NOT LEAVE THE PASSWORD FIELD BLANK**,when prompted; enter the Password for the MySQL root user. Since this is a local development environment just enter _password_; **NEVER** do this on a public facing server.

## [Apache](https://httpd.apache.org/)

To test the server open a browser window and type localhost into the address bar. If your see a page the says _Apache2 Ubuntu Default Page_ your Apache web server is up and running.

The Apache web server will create a path called ```/var/www/``` this is the default path for all of your web application(s). By default root owns this path. Lets make sure we are able to work with path with out requiring elevated privileges.

```sh
ls -l /var
total 52
drwxr-xr-x  2 root root     4096 Feb 16 15:09 
drwxr-xr-x 17 root root     4096 Feb 16 16:06 cache
drwxrwsrwt  2 root whoopsie 4096 Apr 20  2016 crash
drwxr-xr-x 73 root root     4096 Feb 16 16:07 lib
drwxrwsr-x  2 root staff    4096 Apr 12  2016 local
lrwxrwxrwx  1 root root        9 Feb 16 14:28 lock -> /run/lock
drwxr-xr-x 14 root syslog   4096 Feb 16 16:07 log
drwxrwsr-x  2 root mail     4096 Apr 20  2016 mail
drwxrwsrwt  2 root whoopsie 4096 Apr 20  2016 metrics
drwxr-xr-x  2 root root     4096 Apr 20  2016 opt
lrwxrwxrwx  1 root root        4 Feb 16 14:28 run -> /run
drwxr-xr-x  2 root root     4096 Apr 19  2016 snap
drwxr-xr-x  7 root root     4096 Apr 20  2016 spool
drwxrwxrwt  5 root root     4096 Feb 16 16:00 tmp
drwxr-xr-x  3 root root     4096 Feb 16 16:06 www
```
Note the last line of the result set, the one ending with _www_. That is the path we are interested in.

Lets break the result set down by column
* drwxr-xr-x - file permissions by [user]-[group]-[public]
* 3 - the number of links to the file or directory
* root - ownership by user
* group - ownership by group
* 4096 - size
* Feb 16 16:06 - created date
* www - the name of the file or folder

Since you will be the one updating the files on the server, change the ownership to yourself by running the following command. Replace _username_ and _usergroup_ with your user name.

We dive deeper into Apache throughout this course. For now, bookmark [Apache's official documentation](https://httpd.apache.org/docs/2.4/)

```sh
sudo chown username:usergroup -fR /var/www
```

Now if you run ```ls -l``` and you will see yourself as the owner of the path.

### [PHP](http://php.net/)

PHP was installed as a part of ```lamp-server^``` give this a quick test. Open a terminal and type ```php -v```

```sh
php -v

PHP 7.0.13-0ubuntu0.16.04.1 (cli) ( NTS )
Copyright (c) 1997-2016 The PHP Group
Zend Engine v3.0.0, Copyright (c) 1998-2016 Zend Technologies
    with Zend OPcache v7.0.13-0ubuntu0.16.04.1, Copyright (c) 1999-2016, by Zend Technologies
    with Xdebug v2.4.0, Copyright (c) 2002-2016, by Derick Rethans
```

* ```php -v``` This one is pretty simple, we are just asking PHP for it's version number. If you see something begining with _PHP 7._ then is up and running. Make a note of [PHP's documentation](http://php.net/manual/en/intro-whatis.php) to review at your leisure.

## [MySQL](https://www.phpmyadmin.net/)
Now Apache is up and running we want to be able to work with our database. We will start by invoking MySQL from the command line.

```sh
mysql -u root -p -h localhost
```

* ```mysql``` - tells the system to launch a program called mysql.
* ```-u root``` - the MySQL user that will be logging into the system. _root_ is the default user and has the highest level of privilege.
* ```-p``` - tells MySQL to provide a password prompt.
* ```-h localhost``` - the host to which MySQL will connect, in this case it is the local machine.

When prompted type _password_ or whatever password you entered during setup into the command line. If successful you will be presented with a MySQL prompt.

```sh
mysql>
```

We will work with MySQL later in the course, for now bookmark the [MySQL Reference Manual](https://dev.mysql.com/doc/refman/5.7/en/). You'll want to familiarize yourself with this guide.

## [phpMyAdmin](https://www.phpmyadmin.net/)

PhpMyAdmin is a webbased admin tool for MySQL. This is written in PHP and runs on the Apache webserver. We will work with phpMyAdmin throughout this course Here is the [offical documentation](https://docs.phpmyadmin.net/en/latest/) for your convenience. Let's start by installing the software.

```sh
sudo apt install phpmyadmin
```

As the installer is running you will be presented with several prompts. Arrows keys allow you to navigate the the option menus, the space bar is used to select and de-select while enter accepts your selected option.

* We are not running in production enter _password_ at each of the prompts.
* Choose apache2
* Choose YES to db-common

At this point phpMyAdmin is installed but it is not accessible. Now we will configure Apache to grant us access to phpMyAdmin. The following command will use ```vim``` to open an Apache config file with root level privs.

```sh
sudo vim /etc/apache2/apache2.conf
```
Type ```Shift + G``` to move to the bottom of the file. Use the _Up Arrow_ to move the cursor to the next to the last line (directly above the line beginning with _# vim:..._).

Now enter insert mode by typing the letter i, if you see _--insert--_ in the bottom left hand corner enter the following.

```apache
# Include the phpmyadmin configuration
Include /etc/phpmyadmin/apache.conf
```

The first line is just a comment so that you or future dev, admin's, etc will know/remember why that line is there.


Now you will want to restart Apache to upadate the configuration.
```sh
sudo service apache2 restart
```

* [```service```](http://manpages.ubuntu.com/manpages/zesty/man8/service.8.html) - Apache runs a service so all this command does is tell the system to restart the Apache service.

Open a browser and type _localhost/phpmyadmin_ into the address bar. If you see a login page for phpmyadmin then the configuration was successful. Let's go ahead and login using MySQL's root credentials. Smile, you just installed and configured your first web application. While this configuration is fine for a dev environment, you will not want to run this configuration in a production environment. Checkout my post for hardening your phpMyAdmin [PhpMyAdmin Post Configuration](https://jasonsnider.com/posts/view/phpmyadmin-post-configuration)

# [Composer](https://getcomposer.org/)

Composer is package manager for PHP libraries. We will git into the details later, for now, let's just install it.
```sh
sudo apt install composer
```

We have installed several packages, this will be a good time to make sure all of out repositories are still up to date.

```
sudo apt update
sudo apt upgrade
```

## Summary
In this lesson you learned
* how to install a full LAMP stack (Linux)
* how to check package versions using the command line (Linux)
* how to login to MySQL client (Linux, MySQL)

## Additional Resources

* [Apache Web Server Docs](https://httpd.apache.org/docs/)
* [Building a LAMP Stack on Ubuntu 12.04](https://jasonsnider.com/posts/view/building-a-lamp-stack-on-ubuntu-12-04)

### Udemy
* [Host Your Own Web Development Lab from Home!](https://microtrain.udemy.com/web-design-lab/)
* [Next: Apache Basics](05-ApacheBasics.md)
