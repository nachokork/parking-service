# Executables (local)
FPM_CONTAINER = reservation-and-appointments-back-fpm-1

# Docker containers
PHP_CONT = docker exec -it $(FPM_CONTAINER)

# Executables
SYMFONY  = $(PHP_CONT) bin/console

# KEYS PATH
PRIVATE_KEY_PATH=config/jwt/private.pem
PUBLIC_KEY_PATH=config/jwt/public.pem
PASSPHRASE=4f0c6900009d614ac6a61d95053148377cdfcf941599776e1e8b1e4cb1d25171

build: ## Builds the Docker images
	docker compose build --pull --no-cache

up: ## Start the docker hub
	docker compose up -d
sh: ## Connect to the PHP FPM container
	docker exec -it $(FPM_CONTAINER) bash
## —— Migrations ————————————————————————————————————————————————————————————————
migration: ## Create a new migration based on database changes
	$(SYMFONY) make:migration
migrate: ## Execute migrations to database
	$(SYMFONY) doctrine:migrations:migrate -n
db-force-update:
	$(SYMFONY) doctrine:schema:update --force
drop-schema:
	$(SYMFONY) doctrine:schema:drop --force
##---FIXTURES -----##
load-fixtures-append:
	$(SYMFONY) doctrine:fixtures:load --append

## —— Deploy ————————————————————————————————————————————————————————————————
install: ## Deploy the project
	composer install --no-interaction && \
	yarn install && \
	php bin/console doctrine:migrations:migrate -n && \
	php bin/console cache:clear && \
	php bin/console cache:warmup
generate-keys:
	@echo "Generating private and public keys..."
	openssl genpkey -algorithm RSA -out $(PRIVATE_KEY_PATH) -aes256 -pass pass:$(PASSPHRASE) && \
	openssl rsa -pubout -in $(PRIVATE_KEY_PATH) -out $(PUBLIC_KEY_PATH) -passin pass:$(PASSPHRASE)

#dev-deploy: drop-schema migration migrate load-fixtures-append generate-docs