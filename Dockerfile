# ---- Stage 1: Build de assets con Node ----
    FROM node:20-alpine AS node-builder
    WORKDIR /app
    COPY package*.json ./
    RUN npm ci
    COPY . .
    RUN npm run build

    # ---- Stage 2: App PHP ----
    FROM php:8.3-fpm

    # Install dependecys of systems and php extensions
    RUN apt-get update && apt-get install -y \
        git \
        unzip \
        libzip-dev \
        libpng-dev \
        libonig-dev \
        libcurl4-openssl-dev \
        libpq-dev \
        gnupg \
        curl \
        lsb-release \
        apt-transport-https \
        unixodbc \
        unixodbc-dev \
        && docker-php-ext-install \
            zip \
            pdo \
            pdo_mysql \
            pdo_pgsql \
            mbstring \
            exif \
            gd \
            bcmath \
        && apt-get clean \
        && sed -i "s|listen = 127.0.0.1:9000|listen = 0.0.0.0:9000|g" /usr/local/etc/php-fpm.d/www.conf

    # install Composer
    COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

    WORKDIR /var/www/html

    # Copy composer first (cache layer)
    COPY composer.json composer.lock ./
    RUN composer install --no-dev --optimize-autoloader --no-interaction --no-progress

    # copy the rest of the application
    COPY . .

    # copy assets compiled from node-builder
    COPY --from=node-builder /app/public/build ./public/build

    RUN cp .env.example .env
    RUN php artisan key:generate

    RUN chown -R www-data:www-data /var/www/html && chmod -R 775 /var/www/html

    EXPOSE 9000

    CMD ["php-fpm"]
