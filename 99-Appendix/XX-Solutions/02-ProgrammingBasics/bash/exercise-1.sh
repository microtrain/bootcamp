#!/bin/bash

# Disable a vhost configuration
sudo a2dissite default-ssl
sudo service apache2 restart

# Enable a vhost configuration
sudo a2ensite default-ssl
sudo service apache2 restart
