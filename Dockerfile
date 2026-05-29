# =========================
# Laravel 13 Dockerfile
# =========================

FROM php:8.3-fpm

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    unzip \
    zip \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libicu-dev \
    nano \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Configurar extensión GD
RUN docker-php-ext-configure gd --with-freetype --with-jpeg

# Instalar extensiones PHP necesarias para Laravel
RUN docker-php-ext-install \
    pdo \
    pdo_mysql \
    mbstring \
    zip \
    exif \
    pcntl \
    bcmath \
    intl \
    gd

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Directorio principal
WORKDIR /var/www

# Copiar archivos composer primero
COPY composer.json composer.lock ./

# Instalar dependencias Laravel
RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction

# Copiar el resto del proyecto
COPY . .

# Permisos Laravel
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 storage bootstrap/cache

# Optimización Laravel
RUN php artisan config:cache || true
RUN php artisan route:cache || true
RUN php artisan view:cache || true

# Puerto PHP-FPM
EXPOSE 80

# Iniciar PHP-FPM
CMD ["php-fpm"]
