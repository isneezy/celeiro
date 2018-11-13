#!/usr/bin/env bash
psql -c 'create database test;' -U postgres
cp .travis/mysql/phpunit.xml ${DB}-phpunit.xml
phpunit --config ${DB}-phpunit.xml && \
    rm ${DB}-phpunit.xml