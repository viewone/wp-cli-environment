#!/bin/bash

# PHP Lint
for i in $(find ./src ./spec -name '*.php'); do
    php -l "$i"
done

# PHP Code Sniffer
./vendor/bin/phpcs --standard=./build/phpcs.xml ./src

# PHP Mess Detector
./vendor/bin/phpmd ./src text ./build/phpmd.xml

# PHP Copy/Paste Detecotr
./vendor/bin/phpcpd ./src

# PHPSpec
./vendor/bin/phpspec run --format=pretty
