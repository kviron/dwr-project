ARG VER_PHP
FROM php:${VER_PHP}-apache
ARG VER_PHP

RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install bcmath pdo pdo_mysql mysqli mbstring pecl phpize imagick \
    && docker-php-ext-install autoindex_module expires_module limitipconn_module rewrite_module userdir_module \
    && docker-php-ext-enable mbstring autoindex_module expires_module userdir_module rewrite_module limitipconn_module \

RUN apt-get update; \
	apt-get install -yq sudo less git unzip

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# wp-cli
RUN curl -sL https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar -o wp; \
	chmod +x wp; \
	mv wp /usr/local/bin/; \
	mkdir /var/www/.wp-cli; \
	chown www-data:www-data /var/www/.wp-cli

# Install xdebug
RUN pecl install xdebug-3.0.4 \
    && docker-php-ext-enable xdebug

RUN chown -R www-data:www-data /var/www/

WORKDIR /var/www

RUN chown -R www-data:www-data ./