# syntax=docker/dockerfile:experimental
ARG nginx_image
FROM $nginx_image

ARG app_dir
ARG server_name
ARG server_port
ARG user

COPY ./../../docker/stage/nginx/templates /var/tmp/nginx/templates

RUN --mount=type=cache,target=/var/cache/apk set -ex \
    && apk add gettext \
    # rewrite default server configuration
    && rm -f /etc/nginx/conf.d/default.conf \
    && sh -c envsubst $app_dir $server_port $server_name < /var/tmp/nginx/templates/default.conf.template > /etc/nginx/conf.d/default.conf \
    && rm -rf /var/tmp/nginx/templates

USER $user
WORKDIR $app_dir
