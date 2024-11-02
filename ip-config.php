<?php

$to_email = 'email@yahoo-gmail-etc.com';
$from_email = '';
$msg_salt = 'salty_salt';
$msg_page = 'To user';
$view_code = 'To user';

// ln -s /home/walter/Work/git/public-ip-notification-emailer/ip-endpoint.php ip-endpoint.php
// ln -s /home/walter/Work/git/public-ip-notification-emailer/ ip-endpoint.php
// http://localhost/ip-endpoint.php
/*
 * https://www.makeuseof.com/you-dont-have-permission-to-access-on-this-server/
sudo mkdir public-ip-notification-emailer
* cd /var/www/html
* sudo cp /home/walter/Work/git/public-ip-notification-emailer/*.php .
* sudo find /var/www/html -type d -exec chmod 755 {} \;
* sudo find /var/www/html -type f -exec chmod 644 {} \;
* sudo systemctl restart apache2.service
* sudo apt install sqlite3
* sudo apt install php8.1 php8.1-sqlite3 php8.1-fpm
* sudo systemctl reload apache2
* */
