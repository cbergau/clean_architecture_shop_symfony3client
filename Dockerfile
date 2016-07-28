FROM php:7-apache

COPY . /var/www/html

RUN apt-get -yqq update \
    && apt-get install -yqq wget \
    && wget -O - https://download.newrelic.com/548C16BF.gpg | apt-key add - \
    && sh -c 'echo "deb http://apt.newrelic.com/debian/ newrelic non-free" > /etc/apt/sources.list.d/newrelic.list' \
    && apt-get -yqq update \
    && apt-get -yqq install \
        newrelic-php5 \
        git \
        unzip \
    && newrelic-install install \
    && docker-php-ext-install mysqli opcache

# OPCache
RUN { \
		echo 'opcache.memory_consumption=128'; \
		echo 'opcache.interned_strings_buffer=8'; \
		echo 'opcache.max_accelerated_files=4000'; \
		echo 'opcache.revalidate_freq=60'; \
		echo 'opcache.fast_shutdown=1'; \
		echo 'opcache.enable_cli=1'; \
	} > /usr/local/etc/php/conf.d/opcache-recommended.ini

# New Relic configuration
RUN echo "newrelic.license=f7d5ff979f36d064f017a684cc4c4b1f9123156e" >> /usr/local/etc/php/conf.d/newrelic.ini
