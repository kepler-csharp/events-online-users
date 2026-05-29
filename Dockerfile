FROM php:8.3-fpm

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    nginx

# Configurar GD
RUN docker-php-ext-configure gd \
    --with-freetype \
    --with-jpeg

# Instalar extensiones PHP
RUN docker-php-ext-install \
    pdo \
    pdo_mysql \
    mbstring \
    zip \
    exif \
    pcntl \
    gd

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Directorio aplicación
WORKDIR /var/www

# Copiar TODO el proyecto Laravel
COPY . .

# Instalar dependencias Laravel
RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction

# Permisos Laravel
RUN chown -R www-data:www-data /var/www

RUN chmod -R 775 storage bootstrap/cache

# Exponer puerto PHP-FPM
EXPOSE 80

# Iniciar PHP-FPM
CMD ["php-fpm"]
