ARG postgres_image
FROM $postgres_image

COPY ./dev/postgres/docker-entrypoint-db-init.d /docker-entrypoint-db-init.d/
