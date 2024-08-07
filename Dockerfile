FROM php:8.2-apache

ARG user
ARG uid

# Install system dependencies
RUN apt-get update \
    && apt-get install -y git unzip zip npm \
    && apt-get install -y vim \
    && a2enmod ssl \
    && apt-get install -y libpng-dev libonig-dev libxml2-dev

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Get latest Composer
# RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Enable apache rewrite
RUN rm /etc/apache2/sites-available/000-default.conf
COPY /apache2/sites-available/000-default.conf /etc/apache2/sites-available/
RUN a2enmod rewrite

# Custom php configs
COPY /apache2/conf.d/custom.ini /usr/local/etc/php/conf.d/custom.ini

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Set working directory
ENV APP_HOME /var/www
WORKDIR $APP_HOME
COPY . $APP_HOME

RUN cd $APP_HOME && composer install --no-interaction && rm -rf node_modules && npm i && npm run build

RUN chown -R $user:www-data $APP_HOME/storage
RUN chown -R $user:www-data $APP_HOME/bootstrap/cache

RUN cd $APP_HOME && php artisan view:clear

USER $user
