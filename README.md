Clean Architecture Shop
==============
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/5bf37e1e-72fb-4950-9975-7e348beb5ed5/big.png)](https://insight.sensiolabs.com/projects/5bf37e1e-72fb-4950-9975-7e348beb5ed5)

[![Dependency Status](https://www.versioneye.com/user/projects/54eecf652b8e4f0b65000005/badge.svg?style=flat)](https://www.versioneye.com/user/projects/54eecf652b8e4f0b65000005) [![Build Status](https://travis-ci.org/cbergau/clean_arch_shop.svg?branch=master)](https://travis-ci.org/cbergau/clean_arch_shop) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/cbergau/clean_arch_shop/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/cbergau/clean_arch_shop/?branch=master) [![Code Coverage](https://scrutinizer-ci.com/g/cbergau/clean_arch_shop/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/cbergau/clean_arch_shop/?branch=master) [![Code Climate](https://codeclimate.com/github/cbergau/clean_arch_shop/badges/gpa.svg)](https://codeclimate.com/github/cbergau/clean_arch_shop)

Playground for Uncle Bobs' Clean Architecture.

Links for Clean Architecture:
=============================

 - http://blog.8thlight.com/uncle-bob/2012/08/13/the-clean-architecture.html
 - https://www.youtube.com/watch?v=asLUTiJJqdE

Screenshots:
============

![screenshot](screenshot.png)

Registered Customer:
====================
![screenshot](screenshot_registered.png)

Setup:
====

    git clone 
    bin/console doctrine:database:create
    bin/console doctrine:schema:create
    bower install

Include some test data:
====

Use migration/db/example_data.sql

Development:
===

If we use a VOLUME in Docker, then the vendor/ folder might disappear it the host hasn't got it.
So we need to install dependencies again.

Install dependencies with docker:

    docker run --rm -v $(pwd):/app composer/composer install --prefer-dist --ignore-platform-reqs
    docker run -it --rm -v $(pwd):/data digitallyseamless/nodejs-bower-grunt bower install

Run Selenium Tests with docker:

    docker run -d -p 4444:4444 -P --name selenium-hub selenium/hub
    docker run -d --link selenium-hub:hub selenium/node-firefox