consume:	## Run consumers in the background.
	docker-compose run --rm -d consumer supervisord -c /etc/supervisor/supervisord.conf

consume-in-console:	## Run consumers in console.
	docker-compose run --rm consumer supervisord -c /etc/supervisor/supervisord.conf
