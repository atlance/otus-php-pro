$(shell cp -n .env.dev.dist .env && \
 		cp -n ./app/.env.dev.dist ./app/.env && \
 		mkdir -p ./app/var/log ./app/var/run)

include ./.env
export $(shell sed 's/=.*//' ./.env)

-include ./make/${APP_ENV}/**/*.mk
-include ./make/${APP_ENV}/*.mk

RUN_ARGS := $(wordlist 2,$(words $(MAKECMDGOALS)),$(MAKECMDGOALS))
$(eval $(RUN_ARGS):;@:)

env:
	cp .env.${RUN_ARGS}.dist .env

down-clear:	## Down service and remove volumes.
	docker-compose down --remove-orphans -v
	rm -rf ./app/var/* ./app/vendor/*

.PHONY: help

help:	## Display this help
	@awk 'BEGIN {FS = ":.*##"; printf "\nUsage:\n  make \033[36m<target>\033\n\nTargets:\n"} /^[a-zA-Z_-]+:.*?##/ { printf "  \033[36m%-12s\033[0m %s\n", $$1, $$2 }' $(MAKEFILE_LIST)

.DEFAULT_GOAL := help
