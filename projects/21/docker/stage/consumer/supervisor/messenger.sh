#!/bin/sh

if [ -f "/tmp/stop-work.txt" ]; then
  rm -rf /tmp/stop-work.txt
  exit 37
else
  php bin/console messenger:consume async -vv --limit=20 --memory-limit=256M --env=${APP_ENV:-dev}
fi
