# Utilisation d'une image PHP-FPM basée sur Alpine (légère)
FROM php:8.2-fpm-alpine

WORKDIR /var/www/html

# Installer les dépendances système nécessaires pour PHP et Composer et le driver MongoDB
# Ex: pdo_mysql pour la connexion à la base de données
RUN apk add --no-cache \
    autoconf \
    g++ \
    make \
    pkgconfig \
    curl-dev \
    openssl-dev \
    libxml2-dev \
    libzip-dev \
    mysql-client \
    git \
    unzip \
    && rm -rf /var/cache/apk/**

RUN docker-php-ext-install pdo_mysql zip

RUN pecl install mongodb-1.17.0 && \
    docker-php-ext-enable mongodb

# Installer Composer globalement
COPY --from=composer/composer:latest /usr/bin/composer /usr/local/bin/composer

# Copier votre code source dans le conteneur
COPY . .


# Exposer le port PHP-FPM par défaut (9000)
EXPOSE 9000

# Commande par défaut pour PHP-FPM
CMD ["php-fpm"]
