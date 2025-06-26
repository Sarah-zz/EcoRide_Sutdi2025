<?php
$formActionPath = isset($formActionPath) ? htmlspecialchars($formActionPath) : $base_url . '/backend/recherche';

$searchCriteria = $_SESSION['search_criteria'] ?? [];
$prixMax = htmlspecialchars($searchCriteria['prix_max'] ?? '');
$maxDuration = htmlspecialchars($searchCriteria['max_duration'] ?? '');
$minRating = htmlspecialchars($searchCriteria['min_rating'] ?? '');
$electricCar = (bool)($searchCriteria['electric_car'] ?? false);
?>

<div class="container">
    <form action="<?php echo $formActionPath; ?>" method="GET">
        <!-- Champs cachés pour conserver les critères de recherche de base -->
        <input type="hidden" name="ville_depart" value="<?php echo htmlspecialchars($searchCriteria['ville_depart'] ?? ''); ?>">
        <input type="hidden" name="ville_arrivee" value="<?php echo htmlspecialchars($searchCriteria['ville_arrivee'] ?? ''); ?>">
        <input type="hidden" name="date_trajet" value="<?php echo htmlspecialchars($searchCriteria['date_trajet'] ?? ''); ?>">
 <div class="row">
        <div class="col">
            <label for="prixMax" class="form-label text-dark">Prix max (crédits)</label>
            <input type="number" class="form-control" id="prixMax" name="prix_max" placeholder="Ex: 15" min="0" value="<?php echo $prixMax; ?>">
        </div>
        <div class="col">
            <label for="maxDuration" class="form-label text-dark">Durée max (heures)</label>
            <input type="number" class="form-control" id="maxDuration" name="max_duration" placeholder="Ex: 5" min="0" step="1" value="<?php echo $maxDuration; ?>">
        </div>
        <div class="col">
            <label for="minRating" class="form-label text-dark">Note min. conducteur</label>
            <input type="number" class="form-control" id="minRating" name="min_rating" placeholder="Ex: 4" min="0" max="5" step="0.1" value="<?php echo $minRating; ?>">
        </div>
        <div class="col">
            <input class="form-check-input" type="checkbox" id="electricCar" name="electric_car" value="1" <?php echo $electricCar ? 'checked' : ''; ?>>
            <label class="form-check-label text-dark" for="electricCar">Voiture électrique</label>
        </div>
        <div class="col">
            <button type="submit" class="btn btn-primary">Appliquer les filtres</button>
        </div>
        </div>
    </form>
</div>
