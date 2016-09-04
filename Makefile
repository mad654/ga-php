
build: vendor etc/config

test: build
	bin/app example:hello-world

vendor: composer.json composer.lock
	@composer install

etc/config: etc/config.example
	@cp -v etc/config.example etc/config
	@echo
	@echo Updated etc/config file - please check and adjust your settings
