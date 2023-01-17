####
## Build for production
####
FROM alpine:3.13 as production

ADD https://php.hernandev.com/key/php-alpine.rsa.pub /etc/apk/keys/php-alpine.rsa.pub
RUN apk --update-cache add ca-certificates && \
    echo "@php https://php.hernandev.com/v3.13/php-8.1" >> /etc/apk/repositories

RUN apk update && apk upgrade

RUN apk update && apk upgrade && \
    apk add bash vim curl git py-pip jq libcap

RUN pip install --upgrade pip
RUN pip install awscli

RUN apk add --update \
    php@php \
    php-fpm@php \
    php-ctype@php \
    php-curl@php \
    php-dom@php \
    php-iconv@php \
    php-intl@php \
    php-mbstring@php \
    php-opcache@php \
    php-openssl@php \
    php-pdo@php \
    php-phar@php \
    php-session@php \
    php-sockets@php \
    php-xml@php \
    php-zlib@php \
    php-pdo@php \
    php-bcmath@php \
    php-gmp@php \
    php-mongodb@php \
    supervisor \
    nginx

# Create symlink so programs depending on `php` still function
RUN ln -s /usr/bin/php8 /usr/bin/php

# Configure nginx
COPY docker/php/nginx-server.conf /etc/nginx/nginx.conf

# Configure PHP-FPM
COPY docker/php/php-fpm-settings.conf /etc/php8/php-fpm.d/www.conf
COPY docker/php/php-settings.ini /etc/php8/conf.d/custom.ini

# Configure supervisord
COPY docker/php/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Add application
WORKDIR /var/www/html
COPY ./src/ /var/www/html

# Install Composer
ENV COMPOSER_ALLOW_SUPERUSER 1
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer
RUN composer install -o --prefer-dist
RUN composer run-assets

RUN rm /etc/nginx/conf.d/default.conf
# Expose the port nginx is reachable on
EXPOSE 80
EXPOSE 443

ENTRYPOINT ["./secrets-entrypoint.sh"]
# Let supervisord start nginx & php-fpm
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]

####
## Build for local development
####
FROM production as dev

## Xdebug config
COPY docker/php/xdebug.ini /etc/php8/conf.d/xdebug.ini

RUN apk add --update \
    php-pear@php \
    php-xdebug@php
