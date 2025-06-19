CREATE DATABASE ecoride_db;
--------------------------------------------------------
-- Structure de la table `users`

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
    role int DEFAUT '1',
);

-------------
INSERT INTO users (pseudo, first_name, last_name, email, phone, password, credits, profile_picture, rating, role) VALUES
('JeanDupond', 'Jean', 'Dupond', 'jean.dupond@example.com', '0612345678', '$2y$10$E.VlV8k9w0X1z3y5u7i9o1p2a3s4d5f6g7h8j9k0l1m2n3b4v5c6x7z8a9b0c1d', 15, 'profile1.png', 4, 1)
/*      mdp : monSuperMotDePasse123!     */


-------------
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
INSERT INTO trajets (
    conducteur_id,
    ville_depart,
    ville_arrivee,
    date_trajet,
    heure_depart,
    heure_arrivee,
    prix,
    places_disponibles,
    is_electric_car,
    description
) VALUES (
    1,
    'Paris',
    'Marseille',
    '2025-06-20',
    '10:00:00',
    '16:30:00',
    10,
    3,
    FALSE, -- TRUE si c'est une voiture électrique
    'Trajet direct et confortable. Pause déjeuner prévue à mi-chemin.'
);

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