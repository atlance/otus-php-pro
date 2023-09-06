define CLEAR_BUILD_DIR
rm -rf $$(ls $$(ls | grep "site_" | sort -k1r | head -n 3 | awk '\''{ print "--ignore="$$1 }'\'' | tr "\n" " ") | grep "site_")
endef

define CLEAR_DOCKER_IMAGES
docker images -q --filter=reference="${IMAGE}-*:*${IMAGE_TAG}" > need && \
docker images -q | uniq > all && \
(docker rmi -f $$(sdiff need all | grep "[>]" | uniq | awk '\''{ print $$2 }'\'' | tr "\n" " ") || exit 0) && \
rm need all
endef

define CLEAR_DOCKER_NETWORKS
docker network prune -f
endef

define CLEAR_DOCKER_VOLUMES
docker system prune --volumes -f
endef

server-clear:
	ssh ${SSH_USER}@${SSH_HOST} -p ${SSH_PORT} '${CLEAR_DOCKER_IMAGES}'
	ssh ${SSH_USER}@${SSH_HOST} -p ${SSH_PORT} '${CLEAR_DOCKER_NETWORKS}'
	ssh ${SSH_USER}@${SSH_HOST} -p ${SSH_PORT} '${CLEAR_DOCKER_VOLUMES}'
	ssh ${SSH_USER}@${SSH_HOST} -p ${SSH_PORT} '${CLEAR_BUILD_DIR}'

server-deploy:
	ssh ${SSH_USER}@${SSH_HOST} -p ${SSH_PORT} 'rm -rf site_${BUILD_NUMBER}'
	ssh ${SSH_USER}@${SSH_HOST} -p ${SSH_PORT} 'mkdir site_${BUILD_NUMBER}'
	@make env stage
	@make docker-compose
	scp -o StrictHostKeyChecking=no -P ${SSH_PORT} docker-compose.yml ${SSH_USER}@${SSH_HOST}:site_${BUILD_NUMBER}/docker-compose.yml
	ssh ${SSH_USER}@${SSH_HOST} -p ${SSH_PORT} 'docker stop $$(docker ps -q) || exit 0'
	@make server-up
	@make server-create-symlink

server-up:
	ssh ${SSH_USER}@${SSH_HOST} -p ${SSH_PORT} 'cd site_${BUILD_NUMBER} && docker-compose pull -q'
	ssh ${SSH_USER}@${SSH_HOST} -p ${SSH_PORT} 'cd site_${BUILD_NUMBER} && docker stack deploy --compose-file docker-compose.yml'


server-create-symlink:
	ssh ${SSH_USER}@${SSH_HOST} -p ${SSH_PORT} 'rm -f site'
	ssh ${SSH_USER}@${SSH_HOST} -p ${SSH_PORT} 'ln -sr site_${BUILD_NUMBER} site'


server-docker-system-df:
	ssh ${SSH_USER}@${SSH_HOST} -p ${SSH_PORT} 'docker system df'

server-rollback:
	@make server-up
	@make server-create-symlink

