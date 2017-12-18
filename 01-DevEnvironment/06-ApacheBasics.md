# Apache Basics

Open a browser and navigate to http://localhost and you will land on your machines default apache landing page. That is because the default Apache's configuration points to the path ```/var/www/html```, html is folder that contains a single file called index.html. By default Apache looks for files named index.\* (where \* can be any file extension). Let's configure Apache's default path to ```/var/www``` and see what happens.

First, open a command line an navigate to sites-available. On Debian based systems this is where Apache stores per site configurations also known as vhost (virtual host) files, on non-Debian systems these may be part of a larger configuration file. Once in the sites-available directory run the command to list the directory contents.

```sh
cd /etc/apache2/sites-available

ls
```

The ls command should yield the following results.

```sh
000-default.conf  default-ssl.conf
```

000-default.conf is the default configuration for Apache on Debian based systems. Let's take a look at it's contents. You can read this file without sudo but we want to make some changes to it, so lets ```sudo```.

```sh
sudo vim 000-default.conf
```

You will notice a few default settings more commonly called directives in Apache terms. Right now we are only concerned with the ```DocumentRoot``` directive.   Move your cursor down to line 12 and remove _/html_ from the end of this line. Remember ```i``` enters insert mode and ```Esc``` followed by ```:x``` saves the file.

The final result will be.
```apache
DocumentRoot /var/www
```

Now we want to tell apache to reload the configuration. This is a four step process.
* Disable the site configuration ```sudo a2dissite 000-default```
* Reload Apache ```sudo  apache reload```
* Enable the new site configuration ```sudo a2ensite 000-default```
* Reload Apache ```sudo service apache2 reload```

You can execute all four commands at once with the following. 
```sh
sudo a2dissite 0* && sudo service apache2 reload && sudo a2ensite 0* && sudo service apache2 reload
```

```&&``` appends two commands running them one after the other. For example

```sh
cd /etc/apache2/sites-available && vim 0*
```

Would change your current working directory to _/etc/apache2/sites-available && vim 0*_ and use vim to open any files that match the pattern _0*_ in this case it would only one file _000-default.conf_. Using wild cards can save a few key strokes and cut down on typos. But be careful you don't open the wrong files.

Once you have reloaded the the configuration, open your browser and return to _http://localhost _. Now, rather that the default Apache landing page you will see a directory listing with a link to the html directory. Clicking this will open the default Apache landing page.

## [```mod_ssl```](http://httpd.apache.org/docs/current/mod/mod_ssl.html)

Mod_ssl extends the Apache webserver allowing it to work with TLS (Trainsit Layer Security) connections. While TLS long ago replaced SSL (Secure Sockets Layer), SSL is still the common term used for referring to secure connections be it over SSL or TLS.

In your browser navigate to _https://localhost _ notice the _s_ in _https_ this tells the Apache we want to request a secure version of the website. The page should crash, this is because we haven't told Apache we want to enable a secure version of the site. Now lets open the other configuration in the sites-available directory.

```sh
cd /etc/apache2/sites-available
sudo vim default-ssl.conf
```

As in the  previous configuration we are only concerned with the ```DocumentRoot``` directive. Move your cursor down to line with this directive and remove _/html_ from the end of this line. Remember ```i``` enters insert mode and ```Esc``` followed by ```:x``` saves the file.

 While the ```DocumentRoot``` is all we need to change lets take another look at the file. Reopen the file but this time with out ```sudo```. Around line 25 you will see the ```SSLEngine``` directive is set to on. This tells Apache that this configuration wants to use the SSL module, which we have not enabled yet.
Notice lines 32 and 33

```apache
SSLCertificateFile      /etc/ssl/certs/ssl-cert-snakeoil.pem
SSLCertificateKeyFile /etc/ssl/private/ssl-cert-snakeoil.key
```

These directives tell Apache where to find information about out SSL certificates. By default Apache creates a snake oil certificate. This is an invalid certificate that offers encryption with out verification from a CA (certificate authority) such as DigiCert or RapdidSSL. While this is an invalid SSL certificate, it is adequate for testing an SSL connection. Lets enable the SSL module and load load the new configuration. To exit vim without saving any changes press ```ESC``` followed by ```:quit!```.

Now that you have returned to the command line load ```mod_ssl``` (the SSL module).

```sh
sudo a2enmod ssl
```

Now load the new configuration and restart apache. This time we will enable the site using _restart_ instead of _reload_. Reload is a graceful restart that allows minor configuration without killing existing connections. Restart is a hard restart of the server that kills all existing connections. Restart covers reload but reload does not cover restart.

```sh
sudo a2dissite d* && sudo service apache2 reload && sudo a2ensite d* && sudo service apache2 restart
```

Now when you navigate to _https://localhost _ you will get an insecure warning. Accept the warning and proceed to the site against the browsers advise. You will now see the same file listing you saw when navigating to _http://localhost_

## [```mod_rewrite```](http://httpd.apache.org/docs/current/mod/mod_rewrite.html)

Mod_rewrite provide a rules based rewriting engine to Apache. This allows the servers admin to rewrite a users request to do something else. Let's use mod_rewrite to force SSL connections when the user makes an http request.

Be sure the mod_rewrite is enabled

```sh
sudo a2enmod rewrite
```

Open the Apache's default configuration.

```sh
cd /etc/apache2/sites-available && sudo vim 000-default.conf
```

Find the following lines

```apache
ServerAdmin webmaster@localhost
DocumentRoot /var/www
```

and change them to

```apache
ServerAdmin webmaster@localhost

RewriteEngine On
RewriteCond %{HTTPS} off
RewriteRule (.*) https://%{SERVER_NAME}/$1 [R,L]

# DocumentRoot /var/www
```
* ```RewriteEngine On``` - Activates mod_rewrite
* ```RewriteCond %{HTTPS} off``` - Check for a conditions, it this case the https protocol is not active
* ```RewriteRule (.*) https://%{SERVER_NAME}/$1 [R,L]``` - If the condition is true http is rewritten to https.
* \# DocumentRoot /var/www - Comment out the DocumentRoot directive. While not required it would gaurentee no files get served should the redirect fails (in theory).


In a browser navigate to *http://localhost/* and you will be redirected to
*https://localhost/*


```sh
<VirtualHost *:80>
	# The ServerName directive sets the request scheme, hostname and port that
	# the server uses to identify itself. This is used when creating
	# redirection URLs. In the context of virtual hosts, the ServerName
	# specifies what hostname must appear in the request's Host: header to
	# match this virtual host. For the default virtual host (this file) this
	# value is not decisive as it is used as a last resort host regardless.
	# However, you must set it for any further virtual host explicitly.
	#ServerName www.example.com

	ServerAdmin webmaster@localhost
	# DocumentRoot /var/www

	RewriteEngine On
	RewriteCond %{HTTPS} off
	RewriteRule (.*) https://%{SERVER_NAME}/$1 [R,L]

	# Available loglevels: trace8, ..., trace1, debug, info, notice, warn,
	# error, crit, alert, emerg.
	# It is also possible to configure the loglevel for particular
	# modules, e.g.
	#LogLevel info ssl:warn

	ErrorLog ${APACHE_LOG_DIR}/error.log
	CustomLog ${APACHE_LOG_DIR}/access.log combined

	# For most configuration files from conf-available/, which are
	# enabled or disabled at a global level, it is possible to
	# include a line for only one particular virtual host. For example the
	# following line enables the CGI configuration for this host only
	# after it has been globally disabled with "a2disconf".
	#Include conf-available/serve-cgi-bin.conf
</VirtualHost>

# vim: syntax=apache ts=4 sw=4 sts=4 sr noet
```


[Next: NPM](07-NPM.md)
