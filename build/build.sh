#!/bin/bash

php -l ./src/**/*.php
php -l ./spec/**/*.php
./vendor/bin/phpcs --standard=./build/phpcs.xml ./src
./vendor/bin/phpmd ./src text ./build/phpmd.xml
./vendor/bin/phpcpd ./src
./vendor/bin/phpspec run --format=pretty