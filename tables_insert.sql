INSERT INTO users (pseudo, first_name, last_name, email, phone, password, credits, profile_picture, rating, role) VALUES
('JeanDupond', 'Jean', 'Dupond', 'jean.dupond@example.com', '0612345678', '$2y$10$E.VlV8k9w0X1z3y5u7i9o1p2a3s4d5f6g7h8j9k0l1m2n3b4v5c6x7z8a9b0c1d', 15, 'profile1.png', 4, 1)
/*      mdp : monSuperMotDePasse123!     */

INSERT INTO trajets (conducteur_id, ville_depart, ville_arrivee, date_trajet, heure_depart, heure_arrivee, prix, places_disponibles, electric_car, description) VALUES (
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