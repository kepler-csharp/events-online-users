FROM php:8.3-fpm

# Dependencias
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    nodejs \
    npm \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Configuración GD
RUN docker-php-ext-configure gd \
    --with-freetype \
    --with-jpeg

# Extensiones PHP
RUN docker-php-ext-install \
    mbstring \
    zip \
    exif \
    pcntl \
    gd

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Directorio
WORKDIR /var/www

# Copiar proyecto
COPY . .

# Instalar dependencias PHP
RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction

# Frontend
RUN npm install

# Build Vite
RUN npm run build

# Optimizar Laravel
RUN php artisan optimize

# Permisos
RUN chmod -R 777 storage bootstrap/cache

# Puerto
EXPOSE 8089

# Start
CMD php artisan serve --host=0.0.0.0 --port=8089