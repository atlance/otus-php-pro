dump-restore:	## Restore ES dump file.
	docker-compose run --rm php-cli es-check curl -H "Content-Type: application/x-ndjson" -X POST "${ES_URL}/_bulk?pretty" --data-binary "@/dump.json"
