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

RUN apt -y install zlib1g-dev
#RUN docker-php-ext-install zip

##@STCIssue those commented above has phpinsl issues






RUN apt -y install libicu-dev
RUN docker-php-ext-install -j$(nproc) intl

#RUN docker-php-ext-install mbstring

RUN apt-get install -y libfreetype6-dev libjpeg62-turbo-dev libpng-dev


#
#RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ 
#RUN docker-php-ext-install -j$(nproc) gd
##configure wont run above


# Enable apache modules
RUN a2enmod rewrite headers




#@v INstall node.js
RUN apt -y install python3


RUN curl -sL https://deb.nodesource.com/setup_16.x | bash -
RUN apt install -y nodejs




#_____


RUN npm install npm --g


#@v Node dev build base
RUN npm i --g gyp node-pre-gyp 

#@v Minimal dev NPM
RUN npm i --g gulp gulp-watch gulp-plumber gulp-wait gulp-shell gulp-minify gulp-uglify gulp-copy gulp-rename 



########################## ANGULAR STACK #######
#@v Angular Dev tool
RUN npm i --g  @angular/cli







