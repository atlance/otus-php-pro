composer-install:
	docker-compose run --rm php-cli composer install

composer-require:
	docker-compose run --rm php-cli composer require $(filter-out $@,$(MAKECMDGOALS))

composer-remove:
	docker-compose run --rm php-cli composer remove $(filter-out $@,$(MAKECMDGOALS))
