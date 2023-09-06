ARG nginx_image
FROM $nginx_image

ARG app_dir
ARG server_name
ARG server_port
ARG user
ARG uid

COPY ./nginx/templates /var/tmp/nginx/templates

RUN --mount=type=cache,target=/var/cache/apk set -ex \
    && apk add \
      gettext \
    # create user/group
    && addgroup -g $uid -S $user \
    && adduser -S -D -H -u $uid -h /var/cache/nginx -s /sbin/nologin -G $user -g $user $user \
    && chown $user:$user /var/cache/nginx \
    # rewrite default server configuration
    && rm -f /etc/nginx/conf.d/default.conf \
    && sh -c envsubst ${app_dir} ${server_port} ${server_name} < /var/tmp/nginx/templates/default.conf.template > /etc/nginx/conf.d/default.conf \
    # rewrite main nginx configuration
    && sh -c envsubst --variables ${app_dir} ${user} < /var/tmp/nginx/templates/nginx.conf.template > /etc/nginx/nginx.conf \
    && chown $user:$user /etc/nginx/nginx.conf /etc/nginx/conf.d/default.conf \
    && rm -rf /var/tmp/nginx/templates

USER $user:$user
WORKDIR $app_dir
