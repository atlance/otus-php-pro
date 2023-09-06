# syntax=docker/dockerfile:experimental
ARG php_fpm_image
FROM $php_fpm_image AS php-common

ENV PHP_EXT_DIR /usr/local/lib/php/extensions/no-debug-non-zts-20210902
RUN set -ex \
    && if [ `pear config-get ext_dir` != ${PHP_EXT_DIR} ]; then echo PHP_EXT_DIR must be `pear config-get ext_dir` && exit 1; fi

FROM php-common AS php-build
RUN --mount=type=cache,target=/var/cache/apk set -ex \
    && apk add --update-cache $PHPIZE_DEPS

FROM php-build AS php-ext-sockets
RUN docker-php-ext-install sockets

FROM php-common AS php-base
COPY --from=php-ext-sockets ${PHP_EXT_DIR}/sockets.so ${PHP_EXT_DIR}/

RUN docker-php-ext-enable sockets


ARG user
ARG uid
ARG app_dir

RUN addgroup $user && \
    adduser -DS -h /home/$user -u $uid -G $user $user && \
    adduser www-data $user && \
    mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

COPY --chown=$user:$user --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN mv $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini

USER $user:$user
WORKDIR $app_dir
