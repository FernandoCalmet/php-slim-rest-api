.PHONY: up down nginx php phplog nginxlog db coverage vendor

MAKEPATH := $(abspath $(lastword $(MAKEFILE_LIST)))
PWD := $(dir $(MAKEPATH))
CONTAINERS := $(shell docker ps -a -q -f "name=php-slim-rest-api*")

up:
	docker-compose up -d --build

down:
	docker-compose down

nginx:
	docker exec -it php-slim-rest-api-nginx-container bash

php: 
	docker exec -it php-slim-rest-api-php-container bash

phplog: 
	docker logs php-slim-rest-api-php-container

nginxlog:
	docker logs php-slim-rest-api-nginx-container

db:
	docker-compose exec mysql mysql -e 'DROP DATABASE IF EXISTS php_slim_rest_api ; CREATE DATABASE php_slim_rest_api;'
	docker-compose exec mysql sh -c "mysql php_slim_rest_api < docker-entrypoint-initdb.d/database.sql"

coverage:
	docker-compose exec php-fpm sh -c "./vendor/bin/phpunit --coverage-text --coverage-html coverage"

vendor:
	docker-compose exec php-fpm sh -c "composer install"