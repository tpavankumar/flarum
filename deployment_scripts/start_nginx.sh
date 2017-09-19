#!/bin/bash

# Here is where you'd want to stop your http daemon. For example:
sudo rm -rf /etc/nginx/cache/*
sudo service php5-fpm start
sudo service nginx start