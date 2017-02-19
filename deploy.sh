#!/bin/bash
git fetch --all
git reset --hard origin/master
git checkout master
git pull

cd site
php composer.phar install

docker-compose -f docker-compose-prod.yml restart
