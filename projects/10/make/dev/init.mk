prepare:
	@make env dev
	@make docker-compose dev

init: prepare docker-build docker-up ## Build & run app developments containers.
