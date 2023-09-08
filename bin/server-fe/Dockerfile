# FROM php:latest
FROM php:7.1.20-apache
# FROM php:7.1-alpine3.8

RUN apt-get -y update --fix-missing
RUN apt-get upgrade -y



# Install useful tools
RUN apt-get -y install apt-utils nano wget dialog

# Install important libraries
RUN apt-get -y install --fix-missing apt-utils build-essential git curl libcurl3 libcurl3-dev zip

# Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install xdebug
RUN pecl install xdebug-2.5.0
RUN docker-php-ext-enable xdebug

# Other PHP7 Extensions

RUN apt-get -y install libmcrypt-dev
RUN docker-php-ext-install mcrypt

RUN apt-get -y install libsqlite3-dev libsqlite3-0 mysql-client
RUN docker-php-ext-install pdo_mysql 
RUN docker-php-ext-install pdo_sqlite
RUN docker-php-ext-install mysqli

RUN docker-php-ext-install curl
RUN docker-php-ext-install tokenizer
RUN docker-php-ext-install json

RUN apt-get -y install zlib1g-dev
RUN docker-php-ext-install zip

RUN apt-get -y install libicu-dev
RUN docker-php-ext-install -j$(nproc) intl

RUN docker-php-ext-install mbstring

RUN apt-get install -y libfreetype6-dev libjpeg62-turbo-dev libpng-dev
RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ 
RUN docker-php-ext-install -j$(nproc) gd

# Enable apache modules
RUN a2enmod rewrite headers




#@v INstall node.js
RUN apt-get -y install python 


RUN curl -sL https://deb.nodesource.com/setup_10.x | bash -
RUN apt-get install -y nodejs



RUN npm install yarn --g


#@v Node dev build base
RUN yarn global add gyp node-pre-gyp 

#@v Minimal dev NPM
RUN yarn global add gulp gulp-watch gulp-plumber gulp-wait gulp-shell gulp-minify gulp-uglify gulp-copy gulp-rename 



########################## ANGULAR STACK #######
#@v Angular Dev tool
RUN yarn global add  @angular/cli
#RUN yarn global add @angularÃ¢â‚¬â€˜devkit/buildÃ¢â‚¬â€˜angular
RUN yarn global add hammerjs 


########################## FIREBASE STACK #####
#@v Firebase admin
RUN yarn global add  firebase firebase-tools 

RUN yarn global add express.js

########################## EXPRESS / Socket Stack ####
#@v Capable to Host and Serve and Route
RUN yarn global add express-generator 
RUN yarn global add socket.io socket.io-client


# Convertion of Text and stuff
RUN apt-get install -y poppler-utils vim iputils-ping


# Nettool
RUN apt-get install -y net-tools


# Python
RUN apt install -y python-pip
RUN apt install -y python3-pip


# local linking
RUN ln -sf /var/www/html /www