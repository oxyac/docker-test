FROM php:8.0.2-fpm

RUN apt-get update && apt-get install -y \
	git \
	curl \
	zip \
	unzip \
    vim



RUN docker-php-ext-install pdo_mysql
RUN sed -i 's/;error_log = log\/php-fpm.log/error_log = \/proc\/self\/fd\/2\/g/' /usr/local/etc/php-fpm.conf
WORKDIR /var/www
