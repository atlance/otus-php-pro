tests:	## Run phpunit tests.
	docker-compose run --rm php-fpm-1 composer tests
