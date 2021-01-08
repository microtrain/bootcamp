## How to Host your Website on a Linux Machine
Just like on the Windows OS, to host a website on a Linux machine, you need to install Apache, MySQL, and PHP. Rather than installing them separately, LAMP WebServer provides you with a package that carries all the three important web-hosting applications.

**Students Skip to Step 5 [Full Install Details](https://github.com/microtrain/bootcamp/blob/main/01-DevEnvironment/04-LAMPStack.md)**

### Step 1: Install LAMP Software 

LAMP can be installed in any versions of the Linux OS. You should be able to set up the WebServer in the PC whether you prefer the command-line only Ubuntu or a standard Ubuntu desktop. To do that, enter the following simple line of command into the terminal:
```sh
sudo apt install lamp-server^
```
The installation process may take a while due to the download of large volumes of data contained in the package. In the next step, ensure that you set up a password for the MySQL root user then confirm it. Otherwise, if you leave the field empty, you won’t be able to change the password after the LAMP installation process. The password will also come in handy when you want to create other users or update your database.

Another important thing worth noting is that whenever you change the Apache configuration, you have to restart Apache by executing the command ``sudo /etc/init.d/apache2 restart``. However, there is an exception when you carry out the process using the local .htaccess files.

### Step 2: Test the PHP Operation

LAMP provides a test that can verify whether the PHP server is operational as well as check the available modules. To execute it, insert the test PHP file into the WebServer root directory, /var/www/html/. As an example, create a test PHP web page called “name” then enter the following code into the web server root directory:
```sh
sudo echo "" > /var/www/html/name.php
```
After that, go to your browser and type http://localhost/name.php then hit enter. When it loads, it should show you your test PHP file. The running PHP version, configuration, and available modules will be displayed on your window too. You can add new PHP modules later through the Ubuntu package manager in case you come across an application that requires it.

The graphical package manager contains the available modules. You can also access it through the command line by entering the following code: ``apt search php | grep module``. I find the latter much simpler.

### Step 3: Test MySQL and its Bind Address

At this stage, you need to confirm whether MySQL installation was successful. This is because CMS systems such as WordPress won’t run without it. Enter the following command to execute the test: service MySQL status. It should be running upon clicking enter, but if it doesn’t, restart the MySQL server through the following code: ``sudo service mysql restart``.

Also, check whether the bind address of MySQL resembles that of your system. Do this by typing this simple command: ``cat /etc/hosts | grep localhost``. Several results will show on your screen among which include your IP address. Open the MySQL configuration file and check whatever is listed there. Scroll until you see the bind address of your PC. The figures displayed on that line should match those you saw earlier. In case they do not match, change it to finish the test.

You can now use MySQL command line client as a tool for the management of your databases. The admin credentials you had set during the MySQL installation process will give you access to your server. You are now free to manipulate the MySQL environment and can create a database.

Most CMS usually create a database by default. However, you may need to do something extra like backup files or reconfigure tables. For that, you will need a database management tool. PHPMyAdmin is one of the most user-friendly tools used by experts for this job. It offers an interface for the MySQL administration which provides a soft landing spot for those who aren’t well conversant with MySQL and its commands. The next section shows you how to install PHPMyAdmin.

### Step 4: PHPMyAdmin Installation Process

Type the command ``sudo apt-get install phpmyadmin`` to install it. If the installation fails, you will have to reconfigure other repositories before repeating the process. For instance, when you encounter a blue screen inquiring which web server you’d like to configure, press the space bar (the red cursor should be next to the “apache2”). When an asterisk appears, hit the enter button.

A new prompt comes to your monitor inquiring whether phpMyAdmin should create a default database for its exclusive use, click yes. Now you will need to enter your admin username and password to create the database. Restart the Apache to complete the process.

To log into phpMyAdmin, type the following address on your browser: ``http://localhost/phpmyadmin/``. Enter the username and password in the fields provided then click go. It is important to note that the passwords you set for this entire process should be powerful because the web server software gives other people access to your PC.

## Step 5: DNS Configuration

> You may want to configure your local web server to have a personal domain name such as YOUR-DOMAIN.com. To accomplish this, you should change the Apache settings to accept requests from the internet. Below are the particular steps for configuring your DNS:

> Make sure that your domain name of choice has an A record; it should point to a specific IP address. Your DNS records are updated automatically by your DNS hosting service provider. To check whether the configuration was successful, use the dig tool which will return details containing your IP address, domain name, and an authority section.

## Step 6: Configuring of Apache

After downloading and installing the latest version of the LAMP server, Apache will be fully optimized to start hosting websites on your Linux PC. Here are the steps of a simple hosting configuration. They are specifically for name-based virtual hosts which you will use to support sites on your directory.

First, disable the Apache virtual host default by entering the command ``sudo a2dissite *default``. Go to the default storage directory called /var/www/html by typing this command line: ``cd /var/www/html``. Establish a new folder that will host your site. Make sure to change your domain name from example.com to your desired name. Use the command line: ``sudo mkdir YOUR-DOMAIN.com``.

Open the folder you just launched and create other four sub-folders or directories in it. These will serve the purpose of keeping your weblogs, files, and backups. Type this command:
```sh
sudo mkdir -p YOUR-DOMAIN.com/public_html
sudo mkdir -p YOUR-DOMAIN.com/log
sudo mkdir -p YOUR-DOMAIN.com/backups
```
After that, open a new virtual host file for your site through this command:

```sh
sudo vim /etc/apache2/sites-available/YOUR-DOMAIN.com.conf
```
**Note that your domain name _YOUR-DOMAIN.com_ has been replaced by _YOUR-DOMAIN.com.conf_.**

At this stage, you now need to create a configuration for your virtual host. Use the block of code below to help you perform the procedure. You can copy paste it but remember to replace our arbitrary YOUR-DOMAIN.com domain with your own as well as insert the error log command.
```sh
<virtualhost>
ServerAdmin youremail@YOUR-DOMAIN.com
Server_Name YOUR-DOMAIN.com
Server_Alias www.YOUR-DOMAIN.com
located)
Directory_Index index.html index.php (this is the folder in which the files are saved)
Document_Root /var/www/html/YOUR-DOMAIN.com/public_html (contains the name of your php or htm file)
LogLevel warn
Custom_Log /var/www/html/YOUR-DOMAIN.com/log/access.log combined
</virtualhost>
```
To save these changes, press the ``ESC, SHIFT + ; followed by X then Enter button`` to add the changes to the virtual host configuration file.

Finally, enable your site through this command: ```sudo a2ensite YOUR-DOMAIN.com.conf```. You will receive a prompt to restart Apache to apply your new settings. These simple steps will have prepared your Apache to hold your site. You can repeat the procedure for any other websites you would like to host on your LAMP server on your Linux PC.

## Additional Resources
* [Apache HTTP Server Project: VirtualHost Examples](https://httpd.apache.org/docs/2.4/vhosts/examples.html)
* [Advantages of a reverse proxy in front of Node.JS](https://stackoverflow.com/questions/6763571/advantages-of-a-reverse-proxy-in-front-of-node-js)
* [How To Setup A Web Server And Host Website On Your Own Linux Computer](http://www.linuxandubuntu.com/home/how-to-setup-a-web-server-and-host-website-on-your-own-linux-computer)
