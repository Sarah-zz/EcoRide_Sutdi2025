<?php
// Ce contrôleur traite la recherche de trajets et redirige vers la page d'affichage des résultats.

namespace App\Controller;

use App\Repository\TrajetRepository;
use PDOException;

$villeDepart = $_GET['ville_depart'] ?? '';
$villeArrivee = $_GET['ville_arrivee'] ?? '';
$dateTrajet = $_GET['date_trajet'] ?? '';


$results = [];

try {
    $trajetRepository = new TrajetRepository();

    $results = $trajetRepository->searchTrajets( // Appelle la méthode sur TrajetRepository
        $villeDepart,
        $villeArrivee,
        $dateTrajet
    );
} catch (PDOException $e) {
    $_SESSION['error_message'] = "Une erreur est survenue lors de la recherche de trajets. Détails (pour le développement) : " . $e->getMessage();
}

$_SESSION['recherche_results'] = $results;
$_SESSION['search_criteria'] = [
    'ville_depart' => $villeDepart,
    'ville_arrivee' => $villeArrivee,
    'date_trajet' => $dateTrajet,
];


header('Location: ' . $base_url . '/resultats');

exit();
