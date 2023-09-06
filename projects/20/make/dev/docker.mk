docker-compose:
	envsubst < docker-compose.dev.yml > docker-compose.yml

docker-build:	## Buid dev images
	docker-compose build

docker-up:	## Start service.
	docker-compose up -d
