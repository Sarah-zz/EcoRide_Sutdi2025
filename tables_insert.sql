INSERT INTO users (pseudo, first_name, last_name, email, phone, password, credits, profile_picture, rating, role, is_driver, is_passenger, can_be_both) VALUES
('JeanDupond', 'Jean', 'Dupond', 'jean.dupond@example.com', '0612345678', '$2y$10$MAY7AO3RmXVVCKzT3vtkQuf7TUAUz.iwzlx0YJ5AsKjbX0GTtYpn2', 5, 'default_profile.png', 4, 1, 1, 1),
('MarieCurie', 'Marie', 'Curie', 'marie.curie@example.com', '0789012345', '$2y$10$MAY7AO3RmXVVCKzT3vtkQuf7TUAUz.iwzlx0YJ5AsKjbX0GTtYpn2', 12, 'profile_marie.png', 5, 1, 0, 1),
('PaulVerte', 'Paul', 'Verte', 'paul.verte@example.com', '0654321098', '$2y$10$MAY7AO3RmXVVCKzT3vtkQuf7TUAUz.iwzlx0YJ5AsKjbX0GTtYpn2', 8, 'profile_paul.png', 3, 1, 1, 1),
('SophieLambda', 'Sophie', 'Lambda', 'sophie.lambda@example.com', '0600000001', '$2y$10$MAY7AO3RmXVVCKzT3vtkQuf7TUAUz.iwzlx0YJ5AsKjbX0GTtYpn2', 3, 'default_profile.png', 0, 1, 0, 1),
('PierrePassager', 'Pierre', 'Passager', 'pierre.passager@example.com', '0600000002', '$2y$10$MAY7AO3RmXVVCKzT3vtkQuf7TUAUz.iwzlx0YJ5AsKjbX0GTtYpn2', 2, 'default_profile.png', 0, 1, 0, 1),
('AdminUser', 'Admin', 'Site', 'admin@example.com', '078901234', '$2y$10$7JTONpOrDm35EKhJKkDJJ.4NoQz18JJtWsxwwgRrfjY7rKKHJOog2', 9, 'default_profile.png', 5, 3, 0, 1),
('EmployeeUser', 'Employe', 'Support', 'employee@example.com', '0689012345', '$2y$10$9iuTqoU/0Pjb96gbMM7dOuv5HfUtXfymLy4NiWYTs1mA/txnzrRXq', 5, 'default_profile.png', 4, 2, 0, 1);

INSERT INTO vehicles (user_id, brand, model, energy_type, plate_number, first_registration_date, color) VALUES
(1, 'Renault', 'Clio V', 'Essence', 'AB-123-CD', '2019-03-15', 'Bleu'),
(2, 'Tesla', 'Model 3', 'Électrique', 'EF-456-GH', '2021-08-01', 'Blanc'),
(3, 'Peugeot', '308 SW', 'Diesel', 'IJ-789-KL', '2018-11-20', 'Gris'),
(1, 'BMW', 'i3', 'Électrique', 'MN-012-OP', '2020-05-10', 'Noir');

INSERT INTO trajets (conducteur_id, ville_depart, ville_arrivee, date_trajet, heure_depart, heure_arrivee, prix, places_disponibles, electric_car, description) VALUES
(1, 'Paris', 'Lyon', '2025-07-01', '09:00:00', '13:00:00', 30, 2, FALSE, 'Trajet confortable, non-fumeur.'),
(2, 'Lyon', 'Marseille', '2025-07-02', '14:30:00', '17:00:00', 45, 1, TRUE, 'Voiture électrique, pas de bavardage, animaux bienvenus.'),
(1, 'Lyon', 'Paris', '2025-07-03', '07:00:00', '11:00:00', 25, 3, FALSE, 'Retour vers Paris, ambiance radio.'),
(3, 'Bordeaux', 'Toulouse', '2025-07-04', '10:00:00', '12:00:00', 20, 0, FALSE, 'Toutes les places sont prises pour ce trajet, fumeurs et animaux acceptés.'),
(2, 'Nice', 'Cannes', '2025-07-05', '18:00:00', '18:45:00', 10, 4, TRUE, 'Petit trajet côtier en électrique, silencieux.'),
(1, 'Nantes', 'Rennes', '2025-06-25', '08:00:00', '09:30:00', 15, 3, TRUE, 'Départ tôt le matin, voiture électrique confortable.'),
(2, 'Nantes', 'Rennes', '2025-06-25', '10:00:00', '11:45:00', 20, 2, FALSE, 'Trajet national, essence, petite musique.'),
(3, 'Nantes', 'Rennes', '2025-06-25', '13:00:00', '13:45:00', 8, 4, TRUE, 'Court trajet, idéal pour la pause déjeuner, voiture électrique.'),
(1, 'Nantes', 'Rennes', '2025-06-25', '16:00:00', '17:00:00', 12, 1, FALSE, 'Fin de journée, essence, vue sur la mer.');

INSERT INTO reviews (trajet_id, reviewer_id, reviewed_user_id, rating, comment) VALUES
(1, 4, 1, 5, 'Jean est un excellent conducteur, très ponctuel et voiture propre !'),
(2, 5, 2, 4, 'Marie conduit très bien, trajet agréable et silencieux.'),
(NULL, 4, 3, 2, 'Paul est arrivé en retard et la voiture sentait la cigarette. Pas top.'),
(1, 5, 1, 4, 'Deuxième trajet avec Jean, toujours aussi fiable. Super !');