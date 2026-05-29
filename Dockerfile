FROM php:8.3-fpm

# Instalar dependencias del sistema y extensiones de PHP
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
    vim nodejs npm \
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

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configurar el directorio de trabajo
WORKDIR /var/www/html


COPY . .

RUN cp .env.example .env
# Copiar solo composer.json y composer.lock primero (para usar caché)
COPY composer.json composer.lock ./

# Instalar dependencias de Composer
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-progress


RUN chown -R www-data:www-data /var/www/html && chmod -R 775 /var/www/html

EXPOSE 9000

CMD ["php-fpm"]