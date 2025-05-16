# api/Dockerfile
FROM php:8.2-apache

WORKDIR /var/www/html

# Instalar dependencias de Symfony
RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiar archivos y instalar dependencias
COPY . .
RUN composer install

# Habilitar los módulos de Apache necesarios (mod_rewrite y mod_headers)
RUN a2enmod rewrite headers
# Aumentar el tamaño permitido para subida de archivos
RUN echo "upload_max_filesize=20M" > /usr/local/etc/php/conf.d/uploads.ini \
 && echo "post_max_size=25M" >> /usr/local/etc/php/conf.d/uploads.ini
# Copiar el archivo de configuración personalizado de Apache
COPY .docker/apache.conf /etc/apache2/sites-available/000-default.conf

EXPOSE 80
CMD ["apache2-foreground"]