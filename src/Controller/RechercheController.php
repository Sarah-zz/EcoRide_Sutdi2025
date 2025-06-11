<?php
// Ce contrôleur traite la recherche de trajets et redirige vers la page d'affichage des résultats.

namespace App\Controller;

use App\Database\DbConnection;
use PDOException;

// Récupère les données du formulaire de recherche
$villeDepart = $_GET['ville_depart'] ?? '';
$villeArrivee = $_GET['ville_arrivee'] ?? '';
$dateTrajet = $_GET['date_trajet'] ?? '';
$prixMax = $_GET['prix_max'] ?? '';

$pdo = DbConnection::getPdo();

$results = []; // Tableau pour stocker les résultats de la recherche

try {
    $sql = "SELECT
                t.id,
                t.ville_depart,
                t.ville_arrivee,
                t.date_trajet,
                t.heure_depart,
                t.heure_arrivee,
                t.description,
                t.prix,
                t.places_disponibles,
                u.pseudo AS conducteur_pseudo,
                u.profile_picture,
                u.rating,
                t.is_electric_car
            FROM trajets t
            JOIN users u ON t.conducteur_id = u.id
            WHERE t.places_disponibles >= 1";

    $params = [];

    if (!empty($villeDepart)) {
        $sql .= " AND ville_depart LIKE ?";
        $params[] = '%' . $villeDepart . '%';
    }
    if (!empty($villeArrivee)) {
        $sql .= " AND ville_arrivee LIKE ?";
        $params[] = '%' . $villeArrivee . '%';
    }
    if (!empty($dateTrajet)) {
        $sql .= " AND date_trajet = ?";
        $params[] = $dateTrajet;
    }
    if (!empty($prixMax) && is_numeric($prixMax)) {
        $sql .= " AND prix <= ?";
        $params[] = $prixMax;
    }

    $sql .= " ORDER BY t.date_trajet, t.heure_depart";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $results = $stmt->fetchAll();

} catch (PDOException $e) {
    $_SESSION['error_message'] = "Une erreur est survenue lors de la recherche de trajets. Détails (pour le développement) : " . $e->getMessage();
}

$_SESSION['recherche_results'] = $results;
$_SESSION['search_criteria'] = [
    'ville_depart' => $villeDepart,
    'ville_arrivee' => $villeArrivee,
    'date_trajet' => $dateTrajet,
    'prix_max' => $prixMax
];

header('Location: ' . $base_url . '/resultats');

exit();
