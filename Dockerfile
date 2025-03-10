FROM php:8.4-fpm

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libjpeg-dev \
    libonig-dev \
    zip \
    unzip \
    libzip-dev

RUN docker-php-ext-install zip pdo_mysql mbstring exif pcntl bcmath gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN curl -fsSL https://deb.nodesource.com/setup_lts.x | bash -
RUN apt-get install -y nodejs

WORKDIR /var/www/html

COPY . .

# Create directories and set additional permissions.
RUN mkdir -p \
    /var/www/.composer \
    /var/www/.npm \
    storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache \
    vendor \
    node_modules \
    && chown -R www-data:www-data /var/www \
    && chmod -R 775 storage bootstrap/cache

USER www-data

RUN composer install \
    && composer dump-autoload --optimize \
    && npm install \
    && npm run build

EXPOSE 9000
CMD ["php-fpm"]