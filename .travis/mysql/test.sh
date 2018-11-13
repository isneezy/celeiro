#!/usr/bin/env bash
mysql -e 'create database test;'
phpunit --config .travis/mysql/phpunit.xml