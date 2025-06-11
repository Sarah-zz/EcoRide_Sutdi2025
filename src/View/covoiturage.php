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

    </section>
</div>

<div class="text-center mt-5">
    <a href="/EcoRide/" class="btn btn-primary btn-lg">Retour à l'accueil</a>
</div>
</section>
</div>