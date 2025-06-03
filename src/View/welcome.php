<?php

// Définition des variables pour la section hero de la page d'accueil
$title = 'Voyagez vert, voyagez malin avec EcoRide';
$leadText = 'Trouvez ou proposez des covoiturages pour réduire votre empreinte carbone et vos coûts.';

// Définition du chemin d'action pour le formulaire de recherche sur la page d'accueil
// Le chemin est absolu depuis la racine du site, pointant vers le contrôleur de recherche.
$formActionPath = '/backend/recherche';
?>

    <section class="hero-section">
        <div class="container">
            <h1 class="display-4 mb-4"><?php echo htmlspecialchars($title); ?></h1>
            <p class="lead mb-5"><?php echo htmlspecialchars($leadText); ?></p>

            <?php
            // Inclusion du formulaire de recherche
            include __DIR__ . '/../Form/RechercheForm.php';
            ?>
        </div>
    </section>

    <section class="container mt-5">
        <div class="row">
            <div class="col-md-10 offset-md-1 text-center">
                <h2 class="mb-4">Pourquoi choisir EcoRide ?</h2>
                <p class="lead">EcoRide est la plateforme idéale pour des voyages qui ont du sens, pour vous et pour la planète.</p>
                <p>
                    Chaque trajet partagé avec EcoRide est un pas de plus vers un environnement plus sain. En réduisant le nombre de voitures sur nos routes, nous diminuons ensemble la pollution et préservons notre belle nature. C'est simple : moins de voitures, plus d'air pur pour tous.
                </p>
                <p>
                    Partagez des moments agréables, faites de nouvelles rencontres et transformez vos trajets quotidiens ou occasionnels en expériences enrichissantes. C'est l'occasion de voyager utile et de manière plus humaine.
                </p>
                <p>Rejoignez notre communauté grandissante et participez à un avenir plus durable et plus solidaire !</p>
            </div>
        </div>
    </section>

    <section class="container mt-5 py-5 bg-white rounded-lg shadow-sm">
        <div class="row align-items-center mb-5">
            <div class="col-md-6">
                <h2 class="mb-4 text-dark">Notre Mission : Un Covoiturage Responsable</h2>
                <p class="lead text-muted">
                    Chez EcoRide, nous croyons en un avenir où les déplacements sont synonymes de respect de l'environnement et de partage. Notre mission est de faciliter le covoiturage pour tous, en offrant une solution simple, économique et profondément écologique.
                </p>
                <p class="text-muted">
                    Nous nous engageons à réduire l'empreinte carbone de chacun en optimisant l'utilisation des véhicules. Chaque trajet partagé est une victoire pour la planète et pour votre budget. Rejoignez-nous dans cette belle aventure !
                </p>
            </div>
            <div class="col-md-6 text-center">
                <img src="/assets/img/voiture_verte.jpg" alt="[Image of Green Car on Road]" class="img-fluid rounded-3 shadow-sm">
            </div>
        </div>

        <div class="row align-items-center">
            <div class="col-md-6">
                <h2 class="mb-4 text-dark">Une Communauté Engagée et Solidaire</h2>
                <p class="lead text-muted">
                    EcoRide, c'est bien plus qu'une simple plateforme de covoiturage. C'est une communauté de voyageurs qui partagent les mêmes valeurs : l'entraide, le respect et la convivialité.
                </p>
                <p class="text-muted">
                    Faites de nouvelles rencontres, échangez des sourires et des histoires, et transformez vos trajets en moments de partage. Ensemble, nous construisons un réseau de confiance pour des voyages plus humains et plus agréables.
                </p>
            </div>
            <div class="col-md-6 text-center">
                <img src="/assets/img/covoiturage_personnes.jpg" alt="[Image of People Carpooling]" class="img-fluid rounded-3 shadow-sm">
            </div>
        </div>
    </section>
