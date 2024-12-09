FROM docker.io/library/php:7.4-fpm

# Install additional extensions and nginx
RUN apt-get update \
  && apt-get install -y libicu67 libicu-dev libzip4 libzip-dev nginx \
  && docker-php-ext-install pdo pdo_mysql intl pcntl zip

# Setup nginx
COPY ./nginx.conf /etc/nginx/sites-available/default

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
  && chmod +x /usr/local/bin/composer

# Copy php.ini in
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# Copy application code in
COPY . /opt/app

# Install dependencies and symlink webroot.
RUN cd /opt/app \
  && /usr/local/bin/composer install --no-dev --no-interaction \
  && rm -r /var/www/html \
  && ln -s /opt/app/webroot/ /var/www/html

STOPSIGNAL SIGTERM

EXPOSE 5000

# Start both php-fpm and nginx
CMD "/opt/app/run.sh"
