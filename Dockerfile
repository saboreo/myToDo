FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    git \
    libicu-dev \
    libonig-dev \
    libzip-dev \
    unzip

RUN docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install gd pdo pdo_mysql opcache intl mbstring zip

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Set working directory in the container
WORKDIR /var/www

# Copy the application files into the container
COPY . .

RUN composer install --optimize-autoloader --no-dev --no-interaction

# Set correct file permissions
RUN chown -R www-data:www-data /var/www

EXPOSE 9000

CMD ["php-fpm"]