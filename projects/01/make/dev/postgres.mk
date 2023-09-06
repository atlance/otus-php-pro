pg-dump:
	docker-compose exec -u ${POSTGRES_USER} postgres pg_dump -S ${POSTGRES_USER} -Fc ${POSTGRES_DB} > app/var/database/dump/${POSTGRES_DB}.sql
