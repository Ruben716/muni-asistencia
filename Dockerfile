# ========================
# ETAPA 1: Build del frontend con Vite
# ========================
FROM node:18 AS frontend

WORKDIR /app

COPY package*.json ./
RUN npm install

COPY . .
RUN npm run build


# ========================
# ETAPA 2: Laravel con PHP-FPM
# ========================
FROM php:8.2-fpm

# Instalar extensiones necesarias
RUN apt-get update && apt-get install -y \
    git unzip zip libzip-dev libpng-dev libonig-dev libxml2-dev libssl-dev librdkafka-dev \
    && docker-php-ext-install pdo pdo_mysql zip \
    && pecl install rdkafka \
    && docker-php-ext-enable rdkafka

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Establecer directorio de trabajo
WORKDIR /var/www/html

# ✅ COPIAR TODO EL PROYECTO (incluye composer.json, artisan, etc.)
COPY . .

# Copiar solo la build del frontend generada en la etapa anterior
COPY --from=frontend /app/public/build ./public/build

# Instalar dependencias PHP
RUN composer install

# Generar clave de aplicación
RUN php artisan key:generate

# Comando por defecto
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
