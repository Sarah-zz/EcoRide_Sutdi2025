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
    role INT DEFAULT 1 NOT NULL, -- 1=utilisateur, 2=employé, 3=admin
    is_driver BOOLEAN DEFAULT FALSE,
    is_passenger BOOLEAN DEFAULT TRUE
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
    CONSTRAINT fk_conducteur FOREIGN KEY (conducteur_id) REFERENCES users(id) 
    ON DELETE CASCADE
    ON UPDATE CASCADE
);

CREATE TABLE vehicles (
id INT AUTO_INCREMENT PRIMARY KEY,
user_id INT NOT NULL,
brand VARCHAR(100) NOT NULL,
model VARCHAR(100) NOT NULL,
energy_type VARCHAR(50) NOT NULL,
plate_number VARCHAR(20) UNIQUE,
first_registration_date DATE NOT NULL,
color VARCHAR(50) NOT NULL,
CONSTRAINT fk_vehicle_owner FOREIGN KEY (user_id) REFERENCES users(id) 
    ON DELETE CASCADE 
    ON UPDATE CASCADE
);



CREATE TABLE reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    trajet_id INT NULL,
    reviewer_id INT NOT NULL,
    reviewed_user_id INT NOT NULL,
    rating INT NOT NULL CHECK (rating >= 1 AND rating <= 5),
    comment TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_review_trajet
        FOREIGN KEY (trajet_id) REFERENCES trajets(id) 
        ON DELETE SET NULL 
        ON UPDATE CASCADE,

    CONSTRAINT fk_reviewer FOREIGN KEY (reviewer_id) REFERENCES users(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,

    CONSTRAINT fk_reviewed_user FOREIGN KEY (reviewed_user_id) REFERENCES users(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);