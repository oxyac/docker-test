FROM php:8.0.2-fpm

RUN apt-get update && apt-get install -y \
	git \
	curl \
	zip \
	unzip \
    vim \
    emacs \
    nano





RUN docker-php-ext-install pdo pdo_mysql mysqli && docker-php-ext-enable pdo pdo_mysql mysqli

ENV COMPOSER_HOME ./.composer

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php -r "if (hash_file('sha384', 'composer-setup.php') === '55ce33d7678c5a611085589f1f3ddf8b3c52d662cd01d4ba75c0ee0459970c2200a51f492d557530c71c15d8dba01eae') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"

RUN mv composer.phar /usr/local/bin/composer

RUN sed -i 's/;error_log = log\/php-fpm.log/error_log = \/proc\/self\/fd\/2\/g/' /usr/local/etc/php-fpm.conf
WORKDIR /var/www
