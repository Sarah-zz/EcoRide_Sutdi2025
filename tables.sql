CREATE DATABASE ecoride_db;

CREATE TABLE `users` (
    id int AUTO_INCREMENT PRIMARY KEY NOT NULL,
    pseudo varchar(50) NOT NULL,
    first_name varchar(100) NOT NULL,
    last_name varchar(100) NOT NULL,
    email varchar(255) NOT NULL UNIQUE,
    phone varchar(20) DEFAULT NULL,
    password varchar(255) NOT NULL,
    credits int DEFAULT '0',
    profile_picture varchar(255) DEFAULT 'default_profile.png',
    rating int DEFAULT '0',
    role int DEFAULT '1'
);

CREATE TABLE `trajets` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    conducteur_id INT NOT NULL,
    ville_depart VARCHAR(100) NOT NULL,
    ville_arrivee VARCHAR(100) NOT NULL,
    date_trajet DATE NOT NULL,
    heure_depart TIME NOT NULL,
    heure_arrivee TIME NOT NULL,
    prix INT NOT NULL,
    places_disponibles INT NOT NULL,
    electric_car BOOLEAN NOT NULL DEFAULT FALSE, -- Vrai si voiture électrique
    description TEXT,

    CONSTRAINT fk_conducteur
        FOREIGN KEY (conducteur_id)
        REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE
);

-------------


--------------------------------------
CREATE TABLE vehicles (
id INT AUTO_INCREMENT PRIMARY KEY,
user_id INT NOT NULL,
license_plate VARCHAR(20) NOT NULL UNIQUE,
first_registration_date DATE NOT NULL,
brand VARCHAR(100) NOT NULL,
color VARCHAR(50) NOT NULL,
CONSTRAINT fk_vehicle_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE
);