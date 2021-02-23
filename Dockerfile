# FROM php:7.3-fpm # Debian Buster

# Using stretch for a earlier debian version
#   - https://github.com/docker-library/php/issues/865
# Why: "php:7.3-fpm" (Buster) does not have libfreetype6-dev which is
#       required for our ecard generation
FROM php:7.3-fpm-stretch


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
    libzip-dev \
    zip \
    unzip \
    libbz2-dev \
    libgmp-dev

RUN apt-get install libldap2-dev -y && \
    rm -rf /var/lib/apt/lists/* && \
    docker-php-ext-configure ldap --with-libdir=lib/x86_64-linux-gnu/

# libzip-dev - used for zip

# libzip for zip ext
#RUN apt-get install -y zip libzip-dev \
#	&& docker-php-ext-configure zip --with-libzip

# curl: libcurl4-gnutls-dev
# gmp: libgmp-dev
# libldb-dev libldap2-dev

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install bcmath mysqli pdo_mysql bz2 calendar gd gettext gmp intl ldap soap sockets zip
#  odbc pcntl pdo_dblib pdo_pgsql pgsql pspell shmop sysvmsg sysvsem sysvshm wddx tidy xmlrpc xsl


# imagettfbbox
RUN apt-get update
RUN apt-get install -y --no-install-recommends \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
    && docker-php-ext-install -j$(nproc) iconv \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/freetype --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd \
    && rm -r /var/lib/apt/lists/*


# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create system user to run Composer
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Set working directory
WORKDIR /var/www

USER $user
