FROM php:8.1

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
COPY .. /app/app
WORKDIR /app/
RUN chown www-data:www-data /app
RUN sync

#ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN apt update \
    && apt install -y zlib1g-dev g++ git libicu-dev zip libzip-dev zip libxslt1-dev

RUN pecl install apcu && docker-php-ext-enable apcu
RUN docker-php-ext-install mysqli pdo pdo_mysql sockets xsl zip intl opcache


RUN apt install -y librabbitmq-dev libssh-dev \
    && pecl install amqp \
    && docker-php-ext-enable amqp

RUN apt install -y libxml2-dev \
    && docker-php-ext-install soap

RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN mv /root/.symfony5/bin/symfony /usr/local/bin/symfony

RUN apt-get update \
  && apt-get install -y libzip-dev wget --no-install-recommends \
  && apt-get clean \
  && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

CMD bash -c "cd /app/app && composer install && php -a && php bin/console doctrine:migrations:migrate --no-interaction --allow-no-migration && symfony server:start"

EXPOSE 8001