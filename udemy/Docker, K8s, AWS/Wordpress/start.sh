#!/usr/bin/env bash

docker network create blog
docker container run -d -v blog-database:/var/lib/mysql \
	-e MARIADB_ROOT_PASSWORD=pwd123 --network blog --rm --name db mariadb
docker container run -d -e PMA_HOST=db -p 9090:80 --network blog --rm --name blog-phpmyadmin phpmyadmin 
docker run -d -p 9091:80 -v blog-wordpress:/var/www/html \
	--network blog --rm --name blog-wordpress wordpress
