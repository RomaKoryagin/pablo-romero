FROM php:8.4-fpm AS app

ENV APP_ENV=prod

RUN apt-get update && apt-get install -y zlib1g-dev g++ git libicu-dev zip libzip-dev zip libpq-dev \
    && docker-php-ext-install intl opcache pdo pdo_pgsql \
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && docker-php-ext-configure zip

WORKDIR /var/www/app

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .

RUN composer install --no-scripts --no-dev

RUN echo "[www]" > /usr/local/etc/php-fpm.d/zzz-custom.conf && \
    echo "listen = 0.0.0.0:9000" >> /usr/local/etc/php-fpm.d/zzz-custom.conf

EXPOSE 9000

CMD ["php-fpm", "--nodaemonize"]
