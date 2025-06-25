<?php
// Ce contrôleur traite la recherche de trajets et redirige vers la page d'affichage des résultats.

namespace App\Controller;

use App\Repository\TrajetRepository;
use PDOException;

$villeDepart = $_GET['ville_depart'] ?? '';
$villeArrivee = $_GET['ville_arrivee'] ?? '';
$dateTrajet = $_GET['date_trajet'] ?? '';

// Ajouts pour gérer les filtres
$electricCar = isset($_GET['electric_car']) && $_GET['electric_car'] == '1';
$maxDuration = $_GET['max_duration'] ?? '';
$minRating = $_GET['min_rating'] ?? '';


$results = [];

try {
    $trajetRepository = new TrajetRepository();

    $results = $trajetRepository->searchTrajets(
        $villeDepart,
        $villeArrivee,
        $dateTrajet,
        $electricCar,
        $maxDuration,
        $minRating
    );
} catch (PDOException $e) {
    $_SESSION['error_message'] = "Une erreur est survenue lors de la recherche de trajets. Détails (pour le développement) : " . $e->getMessage();
}

$_SESSION['recherche_results'] = $results;
$_SESSION['search_criteria'] = [
    'ville_depart' => $villeDepart,
    'ville_arrivee' => $villeArrivee,
    'date_trajet' => $dateTrajet,
    'electric_car' => $electricCar,
    'max_duration' => $maxDuration,
    'min_rating' => $minRating
];


header('Location: ' . $base_url . '/resultats');

exit();
