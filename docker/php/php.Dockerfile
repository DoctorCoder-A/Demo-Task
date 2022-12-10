FROM php:8-fpm


WORKDIR /var/www/html
COPY . .
COPY conf.d/local.ini /usr/local/etc/php/conf.d/local.ini

# Arguments defined in docker-compose.yml
ARG user
ARG uid

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    libzip-dev \
    libldb-dev  \
    libldap2-dev \
    zip \
    unzip \
    nodejs \
    npm

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install gd zip sockets pdo_mysql ldap exif

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Clean up
RUN apt-get clean \
    && apt-get -y autoremove \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*


# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

USER $user
