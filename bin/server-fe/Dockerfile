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
RUN pecl install xdebug

RUN docker-php-ext-enable xdebug




# Other PHP7 Extensions

RUN apt install libmcrypt-dev -y


RUN apt install libsqlite3* -y

#mysql-client

WORKDIR /root
RUN echo " ">> .bashrc
RUN echo "alias x=exit">> .bashrc


RUN pecl install mcrypt



RUN apt -y install default-mysql-client

RUN docker-php-ext-install pdo_mysql 
RUN docker-php-ext-install pdo_sqlite
RUN docker-php-ext-install mysqli

#RUN docker-php-ext-install curl

#RUN docker-php-ext-install tokenizer
#RUN docker-php-ext-install json

#RUN apt-get -y install zlib1g-dev
#RUN docker-php-ext-install zip

