#!/bin/bash
. `pwd`/.env
if [ ! -d "vendor" ]; then
    composer global require hirak/prestissimo
    composer install
    php .docker/php7/wait-for-db.php
fi
php-fpm