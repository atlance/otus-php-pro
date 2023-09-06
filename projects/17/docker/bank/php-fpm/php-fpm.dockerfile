# syntax=docker/dockerfile:experimental
ARG php_fpm_image
FROM $php_fpm_image AS php-common

ENV PHP_EXT_DIR /usr/local/lib/php/extensions/no-debug-non-zts-20210902
RUN set -ex \
    && if [ `pear config-get ext_dir` != ${PHP_EXT_DIR} ]; then echo PHP_EXT_DIR must be `pear config-get ext_dir` && exit 1; fi

FROM php-common AS php-build
RUN --mount=type=cache,target=/var/cache/apk set -ex \
    && apk add --update-cache $PHPIZE_DEPS

FROM php-build AS php-ext-intl
RUN --mount=type=cache,target=/var/cache/apk set -ex \
    && apk add \
        icu-dev \
	&& docker-php-ext-install intl

FROM php-build AS php-ext-bcmath
RUN --mount=type=cache,target=/var/cache/apk set -ex \
    && docker-php-ext-install bcmath

FROM php-build AS php-ext-pdo
RUN --mount=type=cache,target=/var/cache/apk set -ex \
    && apk add \
        postgresql-dev \
    && docker-php-ext-install pdo_pgsql

FROM php-build AS php-ext-xdebug
RUN set -ex \
    && apk add --update linux-headers \
	&& pecl install xdebug

FROM php-build AS php-ext-memcached
RUN --mount=type=cache,target=/var/cache/apk set -ex \
    && apk add \
        libzip-dev \
        libmemcached-dev \
    && pecl install memcached

FROM php-build AS php-ext-pcntl
RUN set -ex \
    && docker-php-ext-install pcntl

FROM php-build AS php-ext-sockets
RUN set -ex \
    && docker-php-ext-install sockets

FROM php-build AS php-ext-amqp
RUN set -ex \
    && apk add \
        rabbitmq-c-dev \
    && pecl install amqp-1.11.0beta

FROM php-build AS php-ext-gd
RUN --mount=type=cache,target=/var/cache/apk \
    set -ex \
    && apk add \
        libpng-dev \
        libjpeg-turbo-dev \
        freetype-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd

FROM php-build AS php-ext-zip
RUN --mount=type=cache,target=/var/cache/apk \
    set -ex \
    && apk add \
        libzip-dev \
    && docker-php-ext-install zip

FROM php-build AS php-ext-redis
RUN --mount=type=cache,target=/var/cache/apk \
    set -ex \
    && pecl install redis

FROM php-common AS php-base
COPY --from=php-ext-pdo ${PHP_EXT_DIR}/pdo_pgsql.so ${PHP_EXT_DIR}/
COPY --from=php-ext-intl ${PHP_EXT_DIR}/intl.so ${PHP_EXT_DIR}/
COPY --from=php-ext-intl /usr/local /usr/local
COPY --from=php-ext-pcntl ${PHP_EXT_DIR}/pcntl.so ${PHP_EXT_DIR}/
COPY --from=php-ext-bcmath ${PHP_EXT_DIR}/bcmath.so ${PHP_EXT_DIR}/
COPY --from=php-ext-memcached ${PHP_EXT_DIR}/memcached.so ${PHP_EXT_DIR}/
COPY --from=php-ext-xdebug ${PHP_EXT_DIR}/xdebug.so ${PHP_EXT_DIR}/
COPY --from=php-ext-sockets ${PHP_EXT_DIR}/sockets.so ${PHP_EXT_DIR}/
COPY --from=php-ext-amqp ${PHP_EXT_DIR}/amqp.so ${PHP_EXT_DIR}/
COPY --from=php-ext-gd ${PHP_EXT_DIR}/gd.so ${PHP_EXT_DIR}/
COPY --from=php-ext-zip ${PHP_EXT_DIR}/zip.so ${PHP_EXT_DIR}/
COPY --from=php-ext-redis ${PHP_EXT_DIR}/redis.so ${PHP_EXT_DIR}/
RUN --mount=type=cache,target=/var/cache/apk \
    set -ex \
    && apk add libpq icu libpng libjpeg-turbo freetype libzip libmemcached shadow gettext \
    && docker-php-ext-enable pdo_pgsql intl pcntl bcmath memcached xdebug gd zip redis \
    && mv $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini

COPY ./php-fpm/conf.d /usr/local/etc/php/conf.d
COPY ./php-fpm/templates/www.conf.template /var/tmp/php-fpm.d/www.conf.template

ARG bank_dir
ARG user
ARG uid

RUN addgroup $user \
	&& adduser -DSH -u $uid -G $user $user \
	&& adduser www-data $user \
	&& sh -c envsubst ${bank_dir} ${user} < /var/tmp/php-fpm.d/www.conf.template > /usr/local/etc/php-fpm.d/www.conf \
	&& rm /usr/local/etc/php-fpm.d/zz-docker.conf

COPY --chown=$user:$user --from=composer:latest /usr/bin/composer /usr/local/bin/composer

USER $user:$user
WORKDIR $bank_dir