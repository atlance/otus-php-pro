prepare:
	@make env dev
	@make docker-compose dev

init: prepare docker-build docker-up composer-install migrations-migrate ## Build & run app developments containers.
