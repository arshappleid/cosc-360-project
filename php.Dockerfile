FROM php:8.0.0-apache
WORKDIR /var/www/html
RUN docker-php-ext-install mysqli pdo pdo_mysql
## All the following command are to install php-unit
# Install system dependencies for PHPUnit 
RUN apt-get update && apt-get install -y wget
# Download PHPUnit phar
RUN wget https://phar.phpunit.de/phpunit-9.phar
# Make PHPUnit executable
RUN chmod +x phpunit-9.phar
# Move PHPUnit to global bin directory
RUN mv phpunit-9.phar /usr/local/bin/phpunit