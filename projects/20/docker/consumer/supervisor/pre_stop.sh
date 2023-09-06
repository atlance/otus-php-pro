#!/bin/sh

touch /tmp/stop-work.txt
chown www-data:www-data /tmp/stop-work.txt
# Tell workers to stop
php bin/console messenger:stop-workers --env=${APP_ENV:-dev}
# Wait until file has been deleted
until [ ! -f /tmp/stop-work.txt ]
do
    echo "Stop file still exists"
    sleep 5
done

echo "Stop file found, exiting"
