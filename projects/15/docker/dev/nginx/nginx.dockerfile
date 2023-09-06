ARG nginx_image
FROM $nginx_image

ARG app_dir
ARG server_name
ARG fast_cgi

COPY ./common/nginx/templates /var/tmp/nginx/templates

RUN --mount=type=cache,target=/var/cache/apk set -ex \
    && apk add \
      gettext \
    # rewrite default server configuration
    && rm -f /etc/nginx/conf.d/default.conf \
    && sh -c envsubst ${app_dir} ${server_name} ${fast_cgi} < /var/tmp/nginx/templates/default.conf.template > /etc/nginx/conf.d/default.conf \
    # rewrite main nginx configuration
    && sh -c envsubst --variables ${app_dir} < /var/tmp/nginx/templates/nginx.conf.template > /etc/nginx/nginx.conf \
    && rm -rf /var/tmp/nginx/templates
