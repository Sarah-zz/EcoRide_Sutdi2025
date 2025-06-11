<?php
// Cette page affiche le formulaire de recherche de covoiturage.

$formActionPath = '/backend/recherche';
$errorMessage = 'Une erreur est surevenue';

unset($_SESSION['error_message']);
unset($_SESSION['recherche_results']);
?>

<div class="container my-5">
    <section class="covoiturage-section">
        <h1 class="text-center mb-4">Trouvez votre covoiturage idéal</h1>
        <p class="lead text-center">
            Utilisez le formulaire ci-dessous pour rechercher des trajets disponibles.
        </p>

        <?php
        include __DIR__ . '/../Form/RechercheForm.php';
        ?>
        <h2 class="text-center mb-4">Résultats de recherche</h2>

        <?php if ($errorMessage): ?>
            <div class="alert alert-danger text-center" role="alert">
                <?php echo htmlspecialchars($errorMessage); ?>
            </div>
        <?php endif; ?>

        <?php if (empty($rechercheResults)): ?>
            <p class="text-center text-muted">Aucun trajet trouvé pour votre recherche.</p>
        <?php else: ?>
            <p class="lead text-center mb-4">Voici les trajets disponibles qui correspondent à vos critères :</p>
            <div class="row">
                <?php foreach ($rechercheResults as $trajet): ?>
                    <div class="col-md-6 mb-4">
                        <div class="border p-3">
                            <div class="d-flex align-items-center mb-3">
                                <img src="<?php echo htmlspecialchars($base_url ?? ''); ?>/assets/img/<?php echo htmlspecialchars($trajet['profile_picture'] ?? 'default_profile.png'); ?>" alt="[Image of Driver Profile Picture]" class="rounded-circle me-3" style="width: 60px; height: 60px; object-fit: cover;">
                                <div>
                                    <p class="mb-0"><strong><?php echo htmlspecialchars($trajet['conducteur_pseudo']); ?></strong></p>
                                    <p class="mb-0">
                                        <?php
                                        $rating = round($trajet['rating'] ?? 0);
                                        for ($i = 0; $i < 5; $i++) {
                                            if ($i < $rating) {
                                                echo '<i class="bi bi-star-fill text-warning"></i>';
                                            } else {
                                                echo '<i class="bi bi-star text-warning"></i>';
                                            }
                                        }
                                        ?>
                                        (<?php echo htmlspecialchars(number_format($trajet['rating'] ?? 0, 1)); ?>)
                                    </p>
                                </div>
                            </div>
                            <p><strong>Départ :</strong> <?php echo htmlspecialchars($trajet['ville_depart']); ?></p>
                            <p><strong>Arrivée :</strong> <?php echo htmlspecialchars($trajet['ville_arrivee']); ?></p>
                            <p><strong>Date :</strong> <?php echo htmlspecialchars(date('d/m/Y', strtotime($trajet['date_trajet']))); ?></p>
                            <p><strong>Heure de départ :</strong> <?php echo htmlspecialchars(date('H:i', strtotime($trajet['heure_depart']))); ?></p>
                            <p><strong>Heure d'arrivée :</strong> <?php echo htmlspecialchars(date('H:i', strtotime($trajet['heure_arrivee']))); ?></p>
                            <p><strong>Prix :</strong> <?php echo htmlspecialchars($trajet['prix']); ?> crédits</p>
                            <p><strong>Places restantes :</strong> <?php echo htmlspecialchars($trajet['places_disponibles']); ?></p>
                            <?php if (isset($trajet['is_electric_car']) && $trajet['is_electric_car']): ?>
                                <span>Voyage Écologique <i class="bi bi-lightning-fill"></i></span>
                            <?php endif; ?>
                            <div class="mt-3">
                                <a href="#" class="btn btn-primary">Détails du trajet</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="text-center mt-5">
            <a href="/EcoRide/" class="btn btn-secondary btn-lg">Retour à l'accueil</a>
        </div>
    </section>
</div>

<div class="text-center mt-5">
    <a href="/EcoRide/" class="btn btn-primary btn-lg">Retour à l'accueil</a>
</div>
</section>
</div>