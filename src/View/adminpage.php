<?php
// Cette page est l'espace administrateur.

$base_url = '/EcoRide';
?>

<link rel="stylesheet" href="<?php echo $base_url; ?>/assets/css/admin.css">

<div class="container">
    <section class="admin-section">
        <h1 class="text-center mb-5">Espace Administrateur</h1>

        <div class="row">
            <div class="col-md-6">
                <div class="admin-card">
                    <h3>Créer un compte employé</h3>
                    <form action="<?php echo $base_url; ?>/backend/admin_actions" method="POST"> <input type="hidden" name="action" value="create_employee">
                        <div class="mb-3">
                            <label for="employeePseudo" class="form-label">Pseudo</label>
                            <input type="text" class="form-control" id="employeePseudo" name="pseudo" required>
                        </div>
                        <div class="mb-3">
                            <label for="employeeEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="employeeEmail" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="employeePassword" class="form-label">Mot de passe</label>
                            <input type="password" class="form-control" id="employeePassword" name="password" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Créer l'employé</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-md-6">
                <div class="admin-card">
                    <h3>Suspendre un compte</h3>
                    <form action="<?php echo $base_url; ?>/backend/admin_actions" method="POST"> <input type="hidden" name="action" value="suspend_account">
                        <div class="mb-3">
                            <label for="accountId" class="form-label">ID du compte (Pseudo ou Email)</label>
                            <input type="text" class="form-control" id="accountId" name="account_identifier" placeholder="Pseudo ou Email" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-danger">Suspendre le compte</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="admin-card">
                    <h3>Statistiques de la plateforme</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <p class="h4">Crédits totaux gagnés par la plateforme : <strong class="text-success">XXXX crédits</strong></p>
                            <div class="graph-placeholder">Graphique : Covoiturages par jour</div>
                        </div>
                        <div class="col-md-6">
                            <p class="h4">Nombre total de covoiturages : <strong class="text-info">YYYY covoiturages</strong></p>
                            <div class="graph-placeholder">Graphique : Crédits gagnés par jour</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="<?php echo $base_url; ?>/" class="btn btn-secondary btn-lg">Retour à l'accueil</a>
        </div>
    </section>
</div>
