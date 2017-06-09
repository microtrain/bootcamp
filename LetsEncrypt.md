# Let's Encrypt

[Let's Encrypt](https://letsencrypt.org/)

Let's Encrypt provides free and automatic domain validation (DV) certs. [Certbot](https://certbot.eff.org/) is popular utility for installing and maintaining Let's Encrypt certificates.

## Install Certbot
````
sudo apt-get install software-properties-common
sudo add-apt-repository ppa:certbot/certbot
sudo apt-get update
sudo apt-get install python-certbot-apache
````

## Install the Certificate
Run Certbot with the Apache option and follow the prompts.
````
certbot --apache
````

## Certificate Renewal
Use a crontab to auto-renew your cert.
````
crontab -e
````

Add the following line. This will attempt a certificate renewal every day at 10pm. The certificate will only only renew if it is close to expiry.
````
0 22 * * * certbot renew
````

## Additional Reading
[Install Certbot on Ubuntu](https://certbot.eff.org/#ubuntutrusty-apache)
