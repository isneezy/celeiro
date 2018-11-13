#!/usr/bin/env bash
mysql -e 'create database test;'
cp .travis/mysql/phpunit.xml msyql-phpunit.xml
phpunit --config msyql-phpunit.xml && \
    rm msyql-phpunit.xml