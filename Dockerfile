# ---- Stage 1: Build de assets con Node ----
FROM node:20-alpine AS node-builder
WORKDIR /app
COPY package*.json ./
RUN npm ci
COPY . .
RUN npm run build

# ---- Stage 2: App PHP ----
FROM php:8.3-fpm

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

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Primero solo composer files — con --no-scripts para evitar el error de artisan
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --no-interaction --no-progress

# Ahora sí copiar todo el proyecto
COPY . .

# Copiar assets compilados
COPY --from=node-builder /app/public/build ./public/build

# Ahora correr scripts y generar autoloader con el proyecto completo
RUN composer dump-autoload --no-dev --optimize

RUN cp .env.example .env
RUN php artisan key:generate

RUN chown -R www-data:www-data /var/www/html && chmod -R 775 /var/www/html

EXPOSE 9000

CMD ["php-fpm"]
