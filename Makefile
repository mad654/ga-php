
build: vendor etc/config

test: build
	vendor/bin/phpunit -c test/phpunit.xml

vendor: composer.lock

composer.lock: composer.json
	@composer install

etc/config: etc/config.example
	@cp -v etc/config.example etc/config
	@echo
	@echo Updated etc/config file - please check and adjust your settings
