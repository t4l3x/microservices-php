FROM php:8.2

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
COPY .. /app/
WORKDIR /app/

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN chmod +x /usr/local/bin/install-php-extensions && sync && \
    install-php-extensions amqp

RUN apt-get update \
  && apt-get install -y libzip-dev wget --no-install-recommends \
  && apt-get clean \
  && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN docker-php-ext-install zip;

# configure PHP
RUN docker-php-ext-configure zip --with-libzip
RUN docker-php-ext-install pdo_mysql curl json zip

# install dependencies
RUN apk add --no-cache \
    curl \
    libcurl \
    libzip-dev \
    zip \
    caddy
# copy caddy config
COPY ../caddy-config/Caddyfile /etc/caddy/Caddyfile
# run caddy
CMD ["caddy", "-conf", "/etc/caddy/Caddyfile", "-agree"]


CMD bash -c "cd /app && composer install && php -a"
# expose ports
EXPOSE 8000