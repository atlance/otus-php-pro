migration-migrate:	## Migrate migrations.
	docker-compose run --rm php-cli bin/console doctrine:migration:migrate --no-interaction --allow-no-migration
