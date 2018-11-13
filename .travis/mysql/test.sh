#!/usr/bin/env bash
mysql -e 'create database test;'
cp .travis/mysql/phpunit.xml mysql-phpunit.xml
phpunit --config mysql-phpunit.xml && \
    rm mysql-phpunit.xml