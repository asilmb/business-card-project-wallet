IS_IN_CONTAINER := $(shell if [ -f /.dockerenv ]; then echo "true"; fi)

ifeq ($(IS_IN_CONTAINER), true)
	RUN_CMD :=
else
	RUN_CMD := docker compose exec php
endif

.PHONY: all up down stop build shell stan composer-install migrate cache-clear logs

stan:
	$(RUN_CMD) composer stan

test:
	@make db-test-reset
	$(RUN_CMD) php bin/phpunit

db-test-reset:
	$(RUN_CMD) php bin/console doctrine:database:drop --force --if-exists --env=test
	$(RUN_CMD) php bin/console doctrine:database:create --env=test
	$(RUN_CMD) php bin/console doctrine:migrations:migrate --no-interaction --env=test
	$(RUN_CMD) php bin/console doctrine:fixtures:load --no-interaction --env=test

composer-install:
	$(RUN_CMD) composer install

migrate:
	$(RUN_CMD) php bin/console doctrine:migrations:migrate --no-interaction

cache-clear:
	$(RUN_CMD) php bin/console cache:clear

build:
	UID=$(id -u) docker compose up --build -d --force-recreate

up:
	UID=$(id -u) docker compose up -d

down:
	docker compose down

stop:
	docker compose stop

shell: up
	docker compose exec php zsh

logs:
	docker compose logs -f php

setup:
	@if [ ! -f phpstan.neon ]; then \
		echo "Creating local phpstan.neon from dist..."; \
		cp phpstan.neon.dist phpstan.neon; \
		echo "includes:\n    - phpstan-baseline.neon" >> phpstan.neon; \
	fi
	@touch phpstan-baseline.neon
	make composer-install
	$(RUN_CMD) php bin/console lexik:jwt:generate-keypair --skip-if-exists
	make migrate

clr:
	$(RUN_CMD) php bin/console cache:clear