PHPCSFIXER=./vendor/bin/php-cs-fixer fix .
STAN=./vendor/bin/phpstan analyse --memory-limit=1024m --no-progress
PHPUNIT=./vendor/bin/phpunit
COMPOSER_INSTALL=composer install
IMAGE=math

.PHONY: build
build:
	docker build -t $(IMAGE) .

.PHONY: composer
composer:
	docker run --volume=$(PWD):/usr/src/app $(IMAGE) sh -c "$(COMPOSER_INSTALL)"

.PHONY: phpcsfix
phpcsfix:
	docker run --rm -v $(PWD):/usr/src/app $(IMAGE) sh -c "$(COMPOSER_INSTALL) && $(PHPCSFIXER)"

.PHONY: stan
stan:
	docker run --rm -v $(PWD):/usr/src/app $(IMAGE) sh -c "$(COMPOSER_INSTALL) && $(STAN)"

.PHONY: phpunit
phpunit:
	docker run --rm -v $(PWD):/usr/src/app $(IMAGE) sh -c "$(COMPOSER_INSTALL) && $(PHPUNIT)"
