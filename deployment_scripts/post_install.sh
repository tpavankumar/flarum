#!/bin/bash
sudo cat /home/ubuntu/flarum/deployment_scripts/flarum.ini > /etc/php5/fpm/conf.d/gravity.ini
sudo cat /home/ubuntu/flarum/deployment_scripts/nginx.conf > /etc/nginx/nginx.conf
cd /home/ubuntu/flarum
php composer.phar install
php flarum cache:clear
