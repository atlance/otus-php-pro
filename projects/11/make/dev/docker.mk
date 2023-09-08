docker-build:	## Buid dev images
	docker-compose build

docker-up:	## Start service.
	docker-compose up -d

docker-compose:	## Make docker-compose.yml
	envsubst < docker-compose.dev.yml > docker-compose.yml

down-clear:	## Down service and remove volumes.
	docker-compose down --remove-orphans -v
	rm -rf ./app/var/* ./app/vendor/*
