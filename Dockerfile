# PHP 8.2 FPM image
FROM php:8.2-fpm

# Ishchi papka
WORKDIR /var/www/html

# Sistem paketlarni o'rnatish (composer va ba'zi PHP extlar uchun)
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libzip-dev \
    librdkafka-dev \
    && docker-php-ext-install pdo pdo_mysql zip \
    && pecl install rdkafka \
    && docker-php-ext-enable rdkafka

# Composer o'rnatish
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# App fayllarini konteynerga nusxalash
COPY . /var/www/html

# Storage va cache uchun ruxsatlar
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Portni expose qilish
EXPOSE 8000

# Laravel artisan serve ishga tushirish
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
