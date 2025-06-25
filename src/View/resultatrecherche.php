<?php
// Cette page est dédiée à l'affichage des résultats d'une recherche de covoiturage.

$rechercheResults = $_SESSION['recherche_results'] ?? [];
$errorMessage = $_SESSION['error_message'] ?? null;
$searchCriteria = $_SESSION['search_criteria'] ?? [];

unset($_SESSION['recherche_results']);
unset($_SESSION['error_message']);
?>
<div class="container">
    <section class="p-4 rounded-3">
        <h1 class="text-center mb-4">Résultats de votre recherche</h1>

        <?php if ($errorMessage): ?>
            <div class="alert alert-danger text-center" role="alert">
                <?php echo htmlspecialchars($errorMessage); ?>
            </div>
        <?php endif; ?>

        <?php if (empty($rechercheResults)): ?>
            <p class="text-center text-muted">Aucun trajet trouvé pour votre recherche.</p>
            <div class="text-center mt-4">
                <a href="/EcoRide/" class="btn btn-secondary">Retour à l'accueil pour une nouvelle recherche</a>
            </div>

        <?php else: ?>

            <div class="container my-5">
                <div class="row">
                    <section class="bg-white p-4 rounded-3 shadow-sm mb-4">
                        <h2 class="mb-4">Filtrer par :</h2>
                            <?php
                                $formActionPath = $base_url . '/backend/recherche';
                                include __DIR__ . '/../Form/FilterForm.php';
                            ?>
                    </section>
                </div>
                <p class="text-center mb-4">Voici les trajets disponibles qui correspondent à vos critères :</p>
                <div class="row">
                    <?php foreach ($rechercheResults as $trajet): ?>
                        <div class="col-md-6 mb-4">
                            <div class="card h-100 result-card">
                                <h5 class="card-title">
                                    <?php echo ($trajet['ville_depart']); ?> &rarr; <?php echo htmlspecialchars($trajet['ville_arrivee']); ?>
                                </h5>
                                <div class="d-flex align-items-center mb-3">
                                    <img src="<?php echo htmlspecialchars($base_url); ?>/assets/img/profile_picture/<?php echo htmlspecialchars($trajet['profile_picture'] ?? 'default_profile.png'); ?>" alt="[Image of Driver Profile]" class="rounded-circle me-4" style="width: 60px; height: 60px; object-fit: cover;">
                                    <div>
                                        <p class="mb-2"><strong>Conducteur :</strong> <?php echo htmlspecialchars($trajet['conducteur_pseudo']); ?></p>
                                        <p>
                                            <?php
                                            $rawRating = $trajet['rating'] ?? 0;
                                            $roundedRating = round($rawRating);
                                            $starsHtml = '';
                                            for ($i = 0; $i < 5; $i++) {
                                                $starsHtml .= ($i < $roundedRating) ? '<i class="bi bi-star-fill text-warning"></i>' : '<i class="bi bi-star text-warning"></i>';
                                            }
                                            echo $starsHtml . ' (' . htmlspecialchars(number_format($rawRating, 1)) . ')';
                                            ?>
                                        </p>
                                    </div>
                                </div>
                                <p class="card-text mb-1"><strong>Date :</strong> <?php echo htmlspecialchars(date('d/m/Y', strtotime($trajet['date_trajet']))); ?></p>
                                <p class="card-text mb-1"><strong>Heure de départ :</strong> <?php echo htmlspecialchars(date('H:i', strtotime($trajet['heure_depart']))); ?></p>
                                <p class="card-text mb-1"><strong>Descritpion :</strong> <?php echo ($trajet['description']); ?></p>
                                <p class="card-text mb-1"><strong>Prix :</strong> <?php echo htmlspecialchars($trajet['prix']); ?> crédits</p>
                                <p class="card-text mb-1"><strong>Places disponibles :</strong> <?php echo htmlspecialchars($trajet['places_disponibles']); ?></p>
                                <p class="mb-3">
                                    <strong>Voiture électrique :</strong>
                                    <?php if (isset($trajet['is_electric_car']) && $trajet['is_electric_car']): ?>
                                        <span class="badge bg-success"><i class="bi bi-lightning-fill"></i> Oui</span>
                                    <?php else: ?>
                                        Non
                                    <?php endif; ?>
                                </p>
                                <a href="#" class="btn btn-outline-success">Voir les détails</a>
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