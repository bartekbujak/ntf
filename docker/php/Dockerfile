FROM alpine:3.16

RUN apk add --no-cache \
    bash nginx curl jq supervisor tzdata \
    php81-fpm \
    php81-curl \
    php81-ctype \
    php81-dom \
    php81-fileinfo \
    php81-bcmath \
    php81-iconv \
    php81-intl \
    php81-gmp \
    php81-mbstring \
    php81-mongodb \
    php81-opcache \
    php81-openssl \
    php81-pdo \
    php81-phar \
    php81-redis \
    php81-simplexml \
    php81-sockets \
    php81-sodium \
    php81-tokenizer \
    php81-zlib \
    php81-xml \
    php81-xmlwriter

# Create symlink so programs depending on `php` still function
RUN ln -s /usr/bin/php81 /usr/bin/php

# Timezone
RUN apk add tzdata
RUN cp /usr/share/zoneinfo/Europe/Zurich /etc/localtime
RUN echo "Europe/Zurich" >  /etc/timezone
RUN apk del tzdata

# Configure nginx
COPY docker/php/nginx/ /etc/nginx/

COPY docker/php/php/ /etc/php81/

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

RUN chown -R nginx:nginx /var/www/html /run /var/lib/nginx /var/log/nginx

USER nginx

# Expose the port nginx is reachable on
EXPOSE 80
EXPOSE 443

# Let supervisord start nginx & php-fpm
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
