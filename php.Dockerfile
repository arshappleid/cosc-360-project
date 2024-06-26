FROM php:7.4.33-apache
WORKDIR /var/www/html
COPY ./src/ ./
RUN docker-php-ext-install mysqli pdo pdo_mysql
## All the following command are to install php-unit
# Install system dependencies for PHPUnit 
RUN apt-get update && apt-get install -y wget && pear install pear/PHP_CodeSniffer
# Download PHPUnit phar
RUN wget https://phar.phpunit.de/phpunit-9.phar
# Make PHPUnit executable
RUN chmod +x phpunit-9.phar
# Move PHPUnit to global bin directory
RUN mv phpunit-9.phar /usr/local/bin/phpunit