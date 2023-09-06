prepare:
	@make env dev
	@make docker-compose dev

es-check:
	docker-compose run --rm php-cli es-check bin/database

init: prepare docker-build docker-up composer-install es-check ## Build & run app developments containers.
