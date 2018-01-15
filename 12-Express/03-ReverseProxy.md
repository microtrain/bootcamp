# ReverseProxy

Allows Apache to resolve a connection to a running NodeJS instance.


To start up on boot.
```
vim /etc/rc.local
```
Add the line
```
cd /var/www/mean.example.com/app && ./bin/www
```

/etc/rc.local should now look like the following. You MUST start MongoDB prior to starting the website.

```sh
#!/bin/sh -e
#
# rc.local
#
# This script is executed at the end of each multiuser runlevel.
# Make sure that the script will "exit 0" on success or any other
# value on error.
#
# In order to enable or disable this script just change the execution
# bits.
#
# By default this script does nothing.

#start mongo
service mongod start

#start mean.example.com
cd /var/www/mean.example.com/app && ./bin/www

exit 0
```

```sh
sudo a2enmod proxy
sudo a2enmod proxy_http
```
```apache
	<Proxy *>
		Order deny,allow
		Allow from all
	</Proxy>

	ProxyRequests Off
	ProxyPreserveHost On
	ProxyPass / http://localhost:3000/
	ProxyPassReverse / http://localhost:3000/
```
