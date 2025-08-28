#!/usr/bin/env bash

docker container stop db blog-phpmyadmin blog-wordpress
docker network rm blog
