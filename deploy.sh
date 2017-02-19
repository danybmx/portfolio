#!/bin/bash
git checkout master
git fetch --all
git reset --hard origin/master

docker-compose -f docker-compose-prod.yml restart
docker-compose -f docker-compose-prod.yml exec website php /var/www/html/composer.phar install
