<?php
// Cette page est dédiée à l'affichage des résultats d'une recherche de covoiturage.

// Récupère les résultats de recherche stockés dans la session
$rechercheResults = $_SESSION['recherche_results'] ?? [];

$errorMessage = $_SESSION['error_message'] ?? null;
?>

<div class="container my-5">
    <section class="p-4 rounded-3">
        <h1 class="text-center mb-4">Résultats de votre recherche</h1>

        <?php if ($errorMessage): ?>
            <div class="alert alert-danger text-center" role="alert">
                <?php echo ($errorMessage); ?>
            </div>
        <?php endif; ?>

        <?php if (empty($rechercheResults)): ?>
            <p class="text-center text-muted">Aucun trajet trouvé pour votre recherche.</p>
            <div class="text-center mt-4">
                <a href="/EcoRide/" class="btn btn-secondary">Retour à l'accueil pour une nouvelle recherche</a>
            </div>
        <?php else: ?>
            <p class="text-center mb-4">Voici les trajets disponibles qui correspondent à vos critères :</p>
            <div class="row">
                <?php foreach ($rechercheResults as $trajet): ?>
                    <div class="col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title text-primary">
                                    <?php echo htmlspecialchars($trajet['ville_depart']); ?> &rarr; <?php echo htmlspecialchars($trajet['ville_arrivee']); ?>
                                </h5>
                                <p class="card-text mb-1"><strong>Date :</strong> <?php echo htmlspecialchars(date('d/m/Y', strtotime($trajet['date_trajet']))); ?></p>
                                <p class="card-text mb-1"><strong>Heure de départ :</strong> <?php echo htmlspecialchars(date('H:i', strtotime($trajet['heure_depart']))); ?></p>
                                <p class="card-text mb-1"><strong>Conducteur :</strong> <?php echo htmlspecialchars($trajet['conducteur_nom']); ?></p>
                                <p class="card-text mb-1"><strong>Prix :</strong> <?php echo htmlspecialchars($trajet['prix']); ?> crédits</p>
                                <p class="card-text mb-3"><strong>Places disponibles :</strong> <?php echo htmlspecialchars($trajet['places_disponibles']); ?></p>
                                <a href="#" class="btn btn-sm btn-outline-primary">Voir les détails</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="text-center mt-5">
                <a href="/EcoRide/" class="btn btn-primary btn-lg">Retour à l'accueil</a>
            </div>
        <?php endif; ?>
    </section>
</div>