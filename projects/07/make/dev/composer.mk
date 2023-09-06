composer-install:
	docker-compose run --rm server composer install
	docker-compose run --rm client composer install
