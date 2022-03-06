FROM php:apache

COPY api.php /var/www/html/api.php
COPY test.html /var/www/html/test.html
COPY classes /var/www/html/classes/

# Use the default production configuration
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# Signalize PHP that it's running with Docker
ENV DOCKER 1
# 0 or 1 for adding a area code
ENV ADD_AREA_CODE 0
# your area code
ENV AREA_CODE 030

EXPOSE 80