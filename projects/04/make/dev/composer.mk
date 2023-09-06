composer-install:
	docker-compose run --rm php-fpm-1 composer install

tests:
	docker-compose run --rm php-fpm-1 composer tests
