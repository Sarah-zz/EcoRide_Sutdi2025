# Utilisation d'une image PHP-FPM basée sur Alpine (légère)
FROM php:8.2-fpm-alpine

# Définir le répertoire de travail dans le conteneur
WORKDIR /var/www/html

# Installer les dépendances système nécessaires pour PHP et Composer
# Ex: pdo_mysql pour la connexion à la base de données
RUN apk add --no-cache \
    nginx \
    mysql-client \
    git \
    unzip \
    && docker-php-ext-install pdo_mysql

# Installer Composer globalement
COPY --from=composer/composer:latest /usr/bin/composer /usr/local/bin/composer

# Copier votre code source dans le conteneur
# .dockerignore peut être utile ici
COPY . .

# Installer les dépendances PHP via Composer (si elles n'ont pas déjà été installées sur l'hôte)
# Optionnel : si vous voulez que Composer s'exécute à l'intérieur du conteneur
# RUN composer install --no-dev --optimize-autoloader

# Exposer le port PHP-FPM par défaut (9000)
EXPOSE 9000

# Commande par défaut pour PHP-FPM
CMD ["php-fpm"]
