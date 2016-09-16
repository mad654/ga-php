
test: build

run: test
	@bin/app gen-algo:tutorial -vvv
	
build: vendor etc/config

	vendor/bin/phpunit -c test/phpunit.xml

vendor: composer.lock

composer.lock: bin/composer composer.json
	@bin/composer install

bin/composer:
	php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
	php -r "if (hash_file('SHA384', 'composer-setup.php') === 'e115a8dc7871f15d853148a7fbac7da27d6c0030b848d9b3dc09e2a0388afed865e6a3d6b3c0fad45c48e2b5fc1196ae') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
	php composer-setup.php
	php -r "unlink('composer-setup.php');"
	mv composer.phar bin/composer

etc/config: etc/config.example
	@cp -v etc/config.example etc/config
	@echo
	@echo Updated etc/config file - please check and adjust your settings

clean:
	rm -rv vendor
	rm -rv bin/composer
