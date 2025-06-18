#!/bin/sh

# Set PHP-FPM to listen on the port specified by Render
echo "listen = 0.0.0.0:${PORT:-9000}" > /usr/local/etc/php-fpm.d/zz-docker.conf

# Start PHP-FPM
php-fpm 