FROM php:7.4-apache

RUN docker-php-ext-install mysqli pdo_mysql \
    && a2enmod rewrite headers expires deflate

RUN printf 'include_path = ".:/usr/local/lib/php:/var/www/html"\noutput_buffering = On\nsession.cookie_httponly = 1\nsession.cookie_samesite = "Lax"\n' \
    > /usr/local/etc/php/conf.d/app.ini

# Permite .htaccess ler diretivas AllowOverride (necessario para os headers de seguranca do v2/)
RUN echo '<Directory /var/www/html>\n    AllowOverride All\n</Directory>' \
    > /etc/apache2/conf-available/allow-override.conf \
    && a2enconf allow-override
