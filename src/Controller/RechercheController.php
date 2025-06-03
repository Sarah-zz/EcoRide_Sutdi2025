<?php
// src/Controller/RechercheController.php
// Ce contrôleur traite la recherche de trajets et redirige vers la page d'affichage des résultats.

namespace App\Controller;

use App\Database\DbConnection;
use PDOException;

// Récupère les données du formulaire de recherche
$villeDepart = $_GET['ville_depart'] ?? '';
$villeArrivee = $_GET['ville_arrivee'] ?? '';
$dateTrajet = $_GET['date_trajet'] ?? '';
$prixMax = $_GET['prix_max'] ?? '';

// Obtient l'instance PDO directement via la méthode statique getPdo()
$pdo = DbConnection::getPdo();

$results = []; // Tableau pour stocker les résultats de la recherche

try {
    $sql = "SELECT id, ville_depart, ville_arrivee, date_trajet, heure_depart, prix, places_disponibles, conducteur_nom FROM trajets WHERE 1=1";
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

    $sql .= " ORDER BY date_trajet, heure_depart";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $results = $stmt->fetchAll();

} catch (PDOException $e) {
    // Pour une version débutant, on affiche l'erreur directement dans la session.
    // En production, il est préférable de logger l'erreur (avec error_log()) et d'afficher un message générique.
    $_SESSION['error_message'] = "Une erreur est survenue lors de la recherche de trajets. Détails (pour le développement) : " . $e->getMessage();
}

// Stocke les résultats dans la session pour qu'ils soient accessibles sur la page d'affichage
$_SESSION['recherche_results'] = $results;

// Redirige vers la route /resultats du routeur (chemin absolu)
header('Location: /resultats');
exit();
