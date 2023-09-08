# FROM php:latest
#FROM php:7.1.20-apache
FROM php:8.1.23-apache

# FROM php:7.1-alpine3.8



RUN apt update && apt upgrade -y


# Install useful tools
RUN apt -y install nano wget dialog
RUN apt install apt-utils -y


# Install important libraries
RUN apt install build-essential git curl -y
RUN apt install libcurl4 -y
#libcurl*dev -y


#libcurl3 libcurl3-dev zip -y



#
# Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install xdebug
#RUN pecl install xdebug-2.5.0
#RUN docker-php-ext-enable xdebug
RUN pecl --version
