<?php
// La variable $formActionPath doit être définie avant d'inclure ce fichier.
// Elle contiendra le chemin d'URL vers le contrôleur de traitement (ex: /backend/recherche).
// Cette URL est interceptée par le routeur (public/index.php) qui charge ensuite le contrôleur approprié.

namespace App\Form;

$formActionPath = isset($formActionPath) ? htmlspecialchars($formActionPath) : '/backend/recherche';
?>
<div class="search-form-card text-center">
    <h3 class="mb-4 text-dark">Trouvez votre prochain covoiturage</h3>
    <form action="<?php echo $formActionPath; ?>" method="GET">
        <div class="row g-2 align-items-end">
            <div class="col-12 col-md-3">
                <label for="villeDepart" class="form-label text-dark">Ville de départ</label>
                <input type="text" class="form-control" id="villeDepart" name="ville_depart" placeholder="Ex: Paris" required>
            </div>
            <div class="col-12 col-md-3">
                <label for="villeArrivee" class="form-label text-dark">Ville d'arrivée</label>
                <input type="text" class="form-control" id="villeArrivee" name="ville_arrivee" placeholder="Ex: Lyon" required>
            </div>
            <div class="col-12 col-md-3">
                <label for="dateTrajet" class="form-label text-dark">Date</label>
                <input type="date" class="form-control" id="dateTrajet" name="date_trajet" required>
            </div>
            <div class="col-12 col-md-1 d-grid">
                <button type="submit" class="btn btn-primary">Rechercher</button>
            </div>
        </div>
    </form>
</div>
