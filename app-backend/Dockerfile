FROM php:8.2

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
COPY .. /app/
WORKDIR /app/

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN chmod +x /usr/local/bin/install-php-extensions && sync && \
    install-php-extensions amqp
# install dependencies



RUN apt update \
    && apt install -y zlib1g-dev g++ git libicu-dev zip libzip-dev zip \
    && docker-php-ext-install intl opcache pdo pdo_mysql \
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*


CMD bash -c "cd /app && composer install && php -a"
CMD bash -c "php bin/console doctrine:migrations:migrate"

EXPOSE 8001