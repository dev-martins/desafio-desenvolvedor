FROM php:8.3-fpm

# Arguments defined in docker-compose.yml
ARG user
ARG uid

# Install system dependencies
RUN set -eux \
    apt-get upgrade -y \
    apt-cache search libzip | grep libzip-dev \
    apt-get install -y \
            curl \
            libmemcached-dev \
            libz-dev \
            libzip-dev \
            libpq-dev \
            libjpeg-dev \
            libpng-dev \
            libfreetype6-dev \
            libssl-dev \
            libwebp-dev \
            libxpm-dev \
            libmcrypt-dev \
            libonig-dev \
            zlib1g-dev \
            zip \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer; \
    rm -rf /var/lib/apt/lists/*


# Install the PHP libzip extention
RUN apt-get update && apt-get install -y libzip-dev && docker-php-ext-install zip

# Install the PHP libpng extention
RUN apt-get update && apt-get install -y libpng-dev && docker-php-ext-install gd

RUN set -eux; \
    docker-php-ext-install sockets; \
    docker-php-ext-install pdo_mysql; \
    docker-php-ext-install zip; \
    php -r 'var_dump(gd_info());'

# Desabilita o expose_php para evitar vazamento de informação através do cabeçalho HTTP
RUN echo 'expose_php = off' >> /usr/local/etc/php/conf.d/security.ini

# configurar diretivas para o PHP
RUN echo "upload_max_filesize = 100M" > /usr/local/etc/php/conf.d/uploads.ini \
 && echo "post_max_size = 100M" >> /usr/local/etc/php/conf.d/uploads.ini \
 && echo "memory_limit = 256M" >> /usr/local/etc/php/conf.d/uploads.ini \
 && echo "max_execution_time = 1200" >> /usr/local/etc/php/conf.d/uploads.ini \
 && echo "default_socket_timeout = 600" >> /usr/local/etc/php/conf.d/uploads.ini

RUN apt-get update -y && apt-get upgrade -y && apt-get install nginx -y
COPY nginx.conf /etc/nginx/sites-available/default
RUN chown -R www-data /var/www

RUN docker-php-ext-install ftp

CMD php-fpm -D && nginx -g "daemon off;"
EXPOSE 80 443
