# syntax=docker/dockerfile:1.2

# fetch the Composer image, image page: <https://hub.docker.com/_/composer>
FROM composer:2.7.7 as composer

# build application runtime, image page: <https://hub.docker.com/_/php>
FROM php:8.3.8-fpm-alpine as runtime

# install composer, image page: <https://hub.docker.com/_/composer>
COPY --from=composer /usr/bin/composer /usr/bin/composer

ENV COMPOSER_HOME="/tmp/composer"

RUN set -x \
    # install permanent dependencies
    && apk add --no-cache \
        gd \
        freetype \
        libpng \
        libwebp \
        libjpeg-turbo\
        icu-libs \
    # install build-time dependencies
    && apk add --no-cache --virtual .build-deps \
        zlib-dev \
        freetype-dev \
        libpng-dev \
        libwebp-dev \
        libjpeg-turbo-dev\
        postgresql-dev \
        linux-headers \
        autoconf \
        openssl \
        make \
        g++ \
    # install PHP extensions (CFLAGS usage reason - https://bit.ly/3ALS5NU)
    && docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg --with-webp \
    && CFLAGS="$CFLAGS -D_GNU_SOURCE" docker-php-ext-install -j$(nproc) \
        gd \
        pdo_mysql \
        sockets \
        pcntl \
        intl \
        1>/dev/null \
    && pecl install -o redis 1>/dev/null \
    && echo 'extension=redis.so' > ${PHP_INI_DIR}/conf.d/redis.ini \
    # install supercronic (for laravel task scheduling), project page: <https://github.com/aptible/supercronic>
    && wget -q "https://github.com/aptible/supercronic/releases/download/v0.1.12/supercronic-linux-amd64" \
         -O /usr/bin/supercronic \
    && chmod +x /usr/bin/supercronic \
    && mkdir /etc/supercronic \
    && echo '*/1 * * * * php /app/artisan schedule:run' > /etc/supercronic/laravel \
    # generate self-signed SSL key and certificate Files
    && openssl req -x509 -nodes -days 1095 -newkey rsa:2048 \
        -subj "/C=CA/ST=QC/O=Company, Inc./CN=mydomain.com" \
        -addext "subjectAltName=DNS:mydomain.com" \
        -keyout /etc/ssl/private/selfsigned.key \
        -out /etc/ssl/certs/selfsigned.crt \
    && chmod 644 /etc/ssl/private/selfsigned.key \
    # make clean up
    && docker-php-source delete \
    && apk del .build-deps \
    && rm -R /tmp/pear \
    # show installed PHP modules
    && php -m \
    # create unprivileged user
    && adduser \
        --disabled-password \
        --shell "/sbin/nologin" \
        --home "/nonexistent" \
        --no-create-home \
        --uid "10001" \
        --gecos "" \
        "appuser" \
    # create directory for application sources
    && mkdir /app \
    && chown -R appuser:appuser /app

# copy php ini file
RUN cp /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini

# change memory limit
RUN sed -i 's/memory_limit = 128M/memory_limit = 256M/g' /usr/local/etc/php/php.ini

# use an unprivileged user by default
USER appuser:appuser

# use directory with application sources by default
WORKDIR /app

# copy composer (json|lock) Files for dependencies layer caching
COPY --chown=appuser:appuser ./composer.* /app/

# install composer dependencies (autoloader MUST be generated later!)
RUN composer install -n --no-dev --no-cache --no-ansi --no-autoloader --no-scripts --prefer-dist

# copy application sources into image (completely)
COPY --chown=appuser:appuser . /app/

RUN set -x \
    # generate composer autoloader and trigger scripts
    && composer dump-autoload -n --optimize \
    # "fix" composer issue "Cannot create cache directory /tmp/composer/cache/..." for docker-compose usage
    && chmod -R 777 ${COMPOSER_HOME}/cache \
    # create the symbolic links configured for the application
    && php ./artisan storage:link


# unset default image entrypoint
#ENTRYPOINT []
