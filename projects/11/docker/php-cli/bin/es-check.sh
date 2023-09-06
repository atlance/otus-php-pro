#!/bin/sh

printf "\033[36m[Elasticsearch]\033[0m. DB init."
while [[ "$(curl -s -o /dev/null -L -w ''%{http_code}'' ${ES_URL}/_cluster/health?wait_for_status=green&timeout=1s)" != "200" ]]; \
do echo -n "." && sleep 5; \
done;
printf '\033[36mOK!\033[0m\n'
exec "$@"
