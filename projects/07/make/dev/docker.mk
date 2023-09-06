docker-build:	## Buid dev images
	docker-compose build

docker-up:	## Start service.
	docker-compose up -d

server-app:
	docker-compose run --rm server php app.php

client-app:
	docker-compose run --rm client php app.php

docker-compose:	## Make docker-compose.yml
	envsubst < docker-compose.dev.yml > docker-compose.yml

