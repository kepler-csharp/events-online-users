FROM php:8.3-fpm

# Dependencias del sistema
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    vim \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libcurl4-openssl-dev \
    libpq-dev \
    unixodbc \
    unixodbc-dev \
    nodejs \
    npm \
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

# PHP-FPM escuchar externamente
RUN sed -i "s|listen = 127.0.0.1:9000|listen = 0.0.0.0:9000|g" \
    /usr/local/etc/php-fpm.d/www.conf

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copiar composer primero para cache
COPY composer.json composer.lock ./

# Instalar dependencias PHP
RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction \
    --no-progress

# Copiar package files
COPY package*.json ./

# Instalar dependencias node
RUN npm install

# Copiar el resto del proyecto
COPY . .

# Build de Vite
RUN npm run build

# IMPORTANTE:
# eliminar modo dev de vite
RUN rm -f public/hot

# Permisos
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache

# Optimizar Laravel
RUN php artisan config:clear || true
RUN php artisan cache:clear || true
RUN php artisan view:clear || true

EXPOSE 9000

CMD ["php-fpm"]