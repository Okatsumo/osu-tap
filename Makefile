#!/usr/bin/make
# Makefile readme (ru): <http://linux.yaroslavl.ru/docs/prog/gnu_make_3-79_russian_manual.html>
# Makefile readme (en): <https://www.gnu.org/software/make/manual/html_node/index.html#SEC_Contents>

SHELL = /bin/bash
DC_RUN_ARGS = --rm --user "$(shell id -u):$(shell id -g)"

.PHONY : help install shell init test test-cover up down restart clean
.DEFAULT_GOAL : help

# This will output the help for each task. thanks to https://marmelab.com/blog/2016/02/29/auto-documented-makefile.html
help: ## Show this help
	@printf "\033[33m%s:\033[0m\n" 'Available commands'
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z0-9_-]+:.*?## / {printf "  \033[32m%-18s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

install: ## Install all app dependencies
	docker-compose run $(DC_RUN_ARGS) --no-deps osutap composer install --ansi --prefer-dist
	APP_UID=$(shell id -u) APP_GID=$(shell id -g) docker-compose run npm install

shell: ## Start shell into app container
	docker-compose run $(DC_RUN_ARGS) osutap sh

init: ## Make full application initialization
	docker-compose run $(DC_RUN_ARGS) osutap php ./artisan migrate --force --seed
	docker-compose run $(DC_RUN_ARGS) osutap php ./artisan cache:clear
	APP_UID=$(shell id -u) APP_GID=$(shell id -g) docker-compose run npm run build
	-docker-compose run $(DC_RUN_ARGS) --no-deps osutap php ./artisan storage:link

up: ## Create and start containers
	APP_UID=$(shell id -u) APP_GID=$(shell id -g) docker-compose up --detach --remove-orphans --scale queue=2 web queue cron
	@printf "\n   \e[30;42m %s \033[0m\n\n" 'Navigate your browser to ⇒ http://127.0.0.1:8080 or https://127.0.0.1:8443';

down: ## Stop containers
	docker-compose down

restart: down up ## Restart all containers

clean: ## Make clean
	-docker-compose run $(DC_RUN_ARGS) --no-deps osutap sh -c "\
		php ./artisan config:clear; php ./artisan route:clear; php ./artisan view:clear; php ./artisan cache:clear file"
	rm public/storage
	rm -rf node_modules
	rm -rf public/build
	docker-compose down -v # Stops containers and remove named volumes declared in the `volumes` secti

dev: ## npm run dev
	APP_UID=$(shell id -u) APP_GID=$(shell id -g) docker-compose run npm run dev

build: ## build prod frontend
	APP_UID=$(shell id -u) APP_GID=$(shell id -g) docker-compose run npm run build
