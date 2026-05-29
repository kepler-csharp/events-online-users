# ==========================================
# STAGE 1: FRONTEND (VITE)
# ==========================================
FROM node:20 AS frontend

WORKDIR /app

COPY package*.json ./

RUN npm install

COPY . .

RUN npm run build


# ==========================================
# STAGE 2: PHP / LARAVEL
# ==========================================
FROM php:8.3-fpm

# Dependencias del sistema
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libcurl4-openssl-dev \
    libpq-dev \
    unixodbc \
    unixodbc-dev \
    vim \
    && docker-php-ext-install \
        zip \
        pdo \
        pdo_mysql \
        pdo_pgsql \
        mbstring \
        exif \
        gd \
        bcmath \
    && apt-get clean

# Configurar PHP-FPM
RUN sed -i "s|listen = 127.0.0.1:9000|listen = 0.0.0.0:9000|g" \
    /usr/local/etc/php-fpm.d/www.conf

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copiar composer primero para cache
COPY composer.json composer.lock ./

RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction \
    --no-progress

# Copiar proyecto
COPY . .

# Copiar build de Vite desde Node
COPY --from=frontend /app/public/build ./public/build

# Permisos
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache

EXPOSE 9000

CMD ["php-fpm"]