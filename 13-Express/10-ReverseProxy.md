# Reverse Proxy

A reverse proxy allows another web server such as Apache, IIS, Nginx, etc to stand in front of ExpressJS and is recommended as a [production best practice](https://expressjs.com/en/advanced/best-practice-performance.html) by the ExpressJS team. In this example ExpressJS will run on localhost:3000 and Apache will field the requests to *http:loc.mean.example.com* (over port 80) and direct those to *http://localhost:3000*

Install the required Apache mods.
```sh
sudo a2enmod proxy
sudo a2enmod proxy_http
```

Create a VHOST
*/etc/apache2/sites-available/mean.example.com.conf*
```apache
<VirtualHost 127.0.0.102:80>

	ServerName loc.mean.example.com
	ServerAdmin webmaster@localhost

  	<Proxy *>
		Order deny,allow
		Allow from all
	</Proxy>

	ProxyRequests Off
	ProxyPreserveHost On

	ProxyPass / http://localhost:3000/
	ProxyPassReverse / http://localhost:3000/

	ErrorLog ${APACHE_LOG_DIR}/error.log
	CustomLog ${APACHE_LOG_DIR}/access.log combined

</VirtualHost>
```

Update your hosts file

```sh
sudo vim /etc/hosts
```

and add the entry
```sh
127.0.0.102    loc.mean.example.com
```

Open a browser and navigate to [http://loc.mean.example.com](loc.mean.example.com)
## Additional Resources

* [Advantages of a reverse proxy in front of Node.JS
](https://stackoverflow.com/questions/6763571/advantages-of-a-reverse-proxy-in-front-of-node-js)
* [Production best practices: performance and reliability](https://expressjs.com/en/advanced/best-practice-performance.html)
* (Using Nginx as a reverse proxy in front of your Node.js application)[http://www.nikola-breznjak.com/blog/javascript/nodejs/using-nginx-as-a-reverse-proxy-in-front-of-your-node-js-application/]
* [Expose Node.js on an IIS Server by Reverse Proxying With ARR](https://adamtuttle.codes/add-node-to-existing-iis-server/)

[Next: PM2](11-PM2.md)
