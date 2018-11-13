#!/usr/bin/env bash
mysql -e 'create database test;'
phpunit --config ./phpunit.xml