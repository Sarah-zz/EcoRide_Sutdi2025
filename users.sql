CREATE DATABASE ecoride_db;
--------------------------------------------------------
-- Structure de la table `users`

CREATE TABLE `users` (
  id int AUTO_INCREMENT PRIMARY KEY NOT NULL,
  pseudo varchar(50) NOT NULL,
  first_name varchar(100) NOT NULL,
  last_name varchar(100) NOT NULL,
  email varchar(255) NOT NULL,
  phone varchar(20) DEFAULT NULL,
  password varchar(255) NOT NULL,
  credits int DEFAULT '0',
  profile_picture varchar(255) DEFAULT 'default_profile.png',
  rating int DEFAULT '0'
)

-------------
INSERT INTO users (pseudo, first_name, last_name, email, phone, password, credits, profile_picture, rating) VALUES
('JeanDupond', 'Jean', 'Dupond', 'jean.dupond@example.com', '0612345678', 'test', 15, 'profile1.png', 4)

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
    is_electric_car BOOLEAN NOT NULL DEFAULT FALSE, -- Vrai si voiture électrique
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_conducteur
        FOREIGN KEY (conducteur_id)
        REFERENCES users(id)
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
    1, -- Assurez-vous que cet ID de conducteur existe dans votre table 'users'
    'Paris',
    'Marseille',
    '2025-06-20',
    '10:00:00',
    '16:30:00',
    10, -- Le prix est maintenant un entier et ne dépasse pas 10
    3, -- Nombre de places disponibles
    FALSE, -- Mettez TRUE si c'est une voiture électrique
    'Trajet direct et confortable. Pause déjeuner prévue à mi-chemin.'
);