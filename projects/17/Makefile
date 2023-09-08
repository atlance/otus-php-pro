$(shell cp -n .env.dev.dist .env && mkdir -p ./app/var/log ./app/var/run ./bank/var/log ./bank/var/run)

include ./.env
export $(shell sed 's/=.*//' ./.env)

RUN_ARGS := $(wordlist 2,$(words $(MAKECMDGOALS)),$(MAKECMDGOALS))
$(eval $(RUN_ARGS):;@:)

env:
	cp .env.${RUN_ARGS}.dist .env

docker-compose:
	envsubst < docker-compose.dev.yml > docker-compose.yml

init:	## Install and run service.
	@make docker-compose
	@make up
	# application
	docker-compose run --rm app-php-fpm composer install --no-interaction --no-progress
	docker-compose run --rm app-php-fpm bin/console doctrine:migration:migrate --no-interaction
	docker-compose run --rm app-php-fpm bin/console doctrine:fixtures:load --append --no-interaction
	# bank
	docker-compose run --rm bank-php-fpm composer install --no-interaction --no-progress
	docker-compose run --rm bank-php-fpm bin/console doctrine:migration:migrate --no-interaction

up:	## Start service. Rebuild if necessary.
	docker-compose up --build -d

down:	## Down service.
	docker-compose down --remove-orphans

down-clear:	## Down service and remove volumes.
	docker-compose down --remove-orphans -v
	rm -rf ./app/var/* ./bank/var/* ./app/vendor/* ./bank/vendor/*

analyze:	## Run a static code analyzers.
	docker-compose run --rm app-php-fpm composer php-analyze

tests:	## Run phpunit tests.
	docker-compose run --rm app-php-fpm composer tests

.PHONY: help

help:	## Display this help
	@awk 'BEGIN {FS = ":.*##"; printf "\nUsage:\n  make \033[36m<target>\033\n\nTargets:\n"} /^[a-zA-Z_-]+:.*?##/ { printf "  \033[36m%-12s\033[0m %s\n", $$1, $$2 }' $(MAKEFILE_LIST)

.DEFAULT_GOAL := help
