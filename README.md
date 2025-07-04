## Projet EcoRide - ECF Studi

Application de covoiturage en vue du passage de jury en fin d'année.

### Prérequis
Avoir Docker Desktop sur votre machine

### Déploiement local de l'application

* Cloner le dépot git puis aller jusqu'au dossier EcoRide (ou autre si vous changez le nom).
* Créer le fichier .env à la racine du projet (même niveau que le docker-compose.yml) et y ajouter les variables d'environnement nécessaire. Voici un exemple :
```
# Variables pour MySQL
MYSQL_DATABASE=ecoride_db
DB_USER=ecoride_user
DB_PASSWORD=ecoride_password

# Variables pour MongoDB
MONGO_APP_DB=ecoride_app_db
MONGO_INITDB_ROOT_USERNAME=root
MONGO_INITDB_ROOT_PASSWORD=rootpassword
```
*  A la racine du projet, ouvrir le terminal et exécuter ```docker-compose up -d --build```
   Installer les dépendances composer ```docker-compose exec app composer install```
*  L'application est normalement maintenant accessible [(http://localhost:8080/EcoRide/)]


L'application n'est pas encore terminée mais tout a été pushé dans le main pour plus de clarté.

### Fichiers de création et d'intégration de données
Les fichers sont présent sur le dépot git
Pour ma part : utilisation de phpmyadmin avec MySQL, et MongoDB via Mongo Compass





