<?php
// src/View/covoiturage.php
// Cette page affiche le formulaire de recherche de covoiturage.
// Elle est incluse par public/index.php.

// Définition du chemin d'action pour le formulaire de recherche
// Le chemin est absolu depuis la racine du site, pointant vers le contrôleur de recherche.
$formActionPath = '/EcoRide/backend/recherche'; // <--- IMPORTANT: Adaptez ce chemin

// Réinitialise les messages d'erreur si la page est chargée directement via le routeur sans recherche préalable
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

        <div class="text-center mt-5">
            <a href="/EcoRide/" class="btn btn-primary btn-lg">Retour à l'accueil</a> </div>
    </section>
</div>
