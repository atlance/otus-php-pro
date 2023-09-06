prepare:
	@make env dev
	@make docker-compose dev

init: prepare docker-build docker-up composer-install ## Build & run app developments containers.

