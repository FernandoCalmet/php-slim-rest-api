.PHONY: up down nginx php phplog nginxlog db coverage vendor

MAKEPATH := $(abspath $(lastword $(MAKEFILE_LIST)))
PWD := $(dir $(MAKEPATH))
CONTAINERS := $(shell docker ps -a -q -f "name=slim4-api-crud-sql*")

db:
	docker-compose exec mysql mysql -e 'DROP DATABASE IF EXISTS example ; CREATE DATABASE example;'
	docker-compose exec mysql sh -c "mysql example < docker-entrypoint-initdb.d/database.sql"

coverage:
	docker-compose exec php-fpm sh -c "./vendor/bin/phpunit --coverage-text --coverage-html coverage"

vendor:
	docker-compose exec php-fpm sh -c "composer install"

up:
	docker-compose up -d --build

down:
	docker-compose down

nginx:
	docker exec -it slim4-api-crud-sql-nginx-container bash

php: 
	docker exec -it slim4-api-crud-sql-php-container bash

phplog: 
	docker logs slim4-api-crud-sql-php-container

nginxlog:
	docker logs slim4-api-crud-sql-nginx-container
