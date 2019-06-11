FROM php:7.2-apache

MAINTAINER Steven Renault <renaults@loacalhost>

COPY etc/php/php.ini /usr/local/etc/php
RUN a2enmod rewrite

# Install vim..
RUN apt-get update && apt-get install -y vim zlib1g-dev libxml2-dev wget git

# Install pdo_mysql, zip, soap, mysqli
RUN docker-php-ext-install pdo pdo_mysql zip soap mysqli

# Install opcache
RUN docker-php-ext-install opcache

# Install Ted et rtf2pdf.sh
#RUN apt-get update && apt-get install -y gdebi
#RUN cd /tmp
#RUN wget http://ftp.us.debian.org/debian/pool/main/libj/libjpeg8/libjpeg8_8d1-2_amd64.deb \
#   && wget http://security.ubuntu.com/ubuntu/pool/main/t/tiff/libtiff4_3.9.5-2ubuntu1.9_amd64.deb \
#   && wget http://ftp.us.debian.org/debian/pool/main/libp/libpaper/libpaper1_1.1.24+nmu5_amd64.deb \
#   && wget http://ftp.nluug.nl/pub/editors/ted/ted-2.23-amd64.deb \
#   && sudo dpkg -i libjpeg8_8d1-2_amd64.deb \
#   && sudo dpkg -i libtiff4_3.9.5-2ubuntu1.9_amd64.deb \
#   && sudo dpkg -i libpaper1_1.1.24+nmu5_amd64.deb \
#   && sudo dpkg -i ted-2.23-amd64.deb
#RUN apt-get update -qq && apt-get install -y ghostscript imagemagick
#RUN cd /usr/bin/ && wget http://ftp.nluug.nl/pub/editors/ted/rtf2pdf.sh && chmod 775 rtf2pdf.sh

# Install phpdbg
#RUN docker-php-source extract \
#    && cd /usr/src/php \
#	&& ./buildconf --force \
#    && ./configure --enable-phpdbg \
#	&& make -j8 \
#	&& make install-phpdbg \
#	&& make clean \
#	&& docker-php-source delete

# Install Xdebug
#RUN apt-get -y install php5-xdebug \
#    && pecl install 'xdebug'
# Install memcached
#RUN apt-get install -y libz-dev libmemcached-dev \ 
#    && pecl install memcached \
#    && docker-php-ext-enable memcached 
# Install MongoDb ext 
#RUN pecl install mongo \
#   && apt-get -y install libssl-dev \
#   && curl -L -o /tmp/mongo.tar.gz https://github.com/mongodb/mongo-php-driver-legacy/archive/1.6.14.tar.gz \
#   && tar xfz /tmp/mongo.tar.gz -C /tmp/ \
#   && mkdir -p /usr/src/php/ext/mongo \
#   && mv /tmp/mongo-php-driver-legacy-1.6.14/* /usr/src/php/ext/mongo \
#   && rm -r /tmp/mongo.tar.gz /tmp/mongo-php-driver-legacy-1.6.14 \
#   && cd /usr/src/php/ext/mongo \
#   && phpize \
#   && ./configure \
#   && make all \
#   && docker-php-ext-install mongo \
#   && docker-php-ext-enable mongo
# Install composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php
RUN php composer-setup.php --install-dir=/usr/bin --filename=composer
RUN php -r "unlink('composer-setup.php');"
# Install PHPUNIT
RUN wget https://phar.phpunit.de/phpunit-6.1.phar \
    && chmod +x phpunit-6.1.phar \
	&& mv phpunit-6.1.phar /usr/local/bin/phpunit
# Install Java 7
#RUN apt-get install -y openjdk-7-jre --fix-missing \
#    && apt-get install -y openjdk-7-jdk --fix-missing \ 
#    && apt-get install libmysql-java --fix-missing
#RUN export CLASSPATH=$CLASSPATH:/usr/share/java/mysql.jar
RUN apt-get install xvfb libfontconfig wkhtmltopdf -y
