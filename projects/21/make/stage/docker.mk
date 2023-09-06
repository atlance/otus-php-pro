docker-compose:
	envsubst < docker-compose.stage.yml > docker-compose.yml

docker-build:	## Buid stage images
	docker --log-level=debug build \
		   --pull --file=docker/stage/redis/redis.dockerfile \
		   --tag=${IMAGE}-redis:${IMAGE_TAG} \
		   --build-arg redis_image=${REDIS_IMAGE} \
		   --build-arg app_dir=${APP_DIR} \
		   --build-arg user=www-data \
		   .
	docker --log-level=debug build \
		   --pull \
		   --file=docker/stage/rabbitmq/rabbitmq.dockerfile \
		   --tag=${IMAGE}-rabbitmq:${IMAGE_TAG} \
		   --build-arg rabbitmq_image=${RABBITMQ_IMAGE} \
		   --build-arg app_dir=${APP_DIR} \
		   --build-arg user=www-data \
		   .
	docker --log-level=debug build \
		   --pull \
		   --file=docker/stage/php-fpm/php-fpm.dockerfile \
		   --tag=${IMAGE}-php-fpm:${IMAGE_TAG} \
		   --build-arg php_fpm_image=${PHP_FPM_IMAGE} \
		   --build-arg app_dir=${APP_DIR} \
		   --build-arg user=www-data \
		   .
	docker --log-level=debug build \
		   --pull \
		   --file=docker/stage/php-cli/php-cli.dockerfile \
		   --tag=${IMAGE}-php-cli:${IMAGE_TAG} \
		   --build-arg php_cli_image=${PHP_CLI_IMAGE} \
		   --build-arg app_dir=${APP_DIR} \
		   --build-arg user=www-data \
		   .
	docker --log-level=debug build \
		   --pull \
		   --file=docker/stage/consumer/consumer.dockerfile \
		   --tag=${IMAGE}-consumer:${IMAGE_TAG} \
		   --build-arg consumer_image=${PHP_CLI_IMAGE} \
		   --build-arg app_dir=${APP_DIR} \
		   --build-arg user=www-data \
		   .
	docker --log-level=debug build \
		   --pull \
		   --file=docker/stage/nginx/nginx.dockerfile \
		   --tag=${IMAGE}-nginx:${IMAGE_TAG} \
		   --build-arg nginx_image=${NGINX_IMAGE} \
		   --build-arg app_dir=${APP_DIR} \
		   --build-arg user=www-data \
		   --build-arg server_name=${SERVER_NAME} \
		   --build-arg server_port=${SERVER_PORT} \
		   .

docker-push:
	docker login -u ${DOCKER_REGISTRY} -p ${DOCKER_PASSWORD}
	docker-compose push redis rabbitmq php-fpm php-cli consumer nginx
