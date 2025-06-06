<?php
// Cette page contient le formulaire de connexion.

$base_url = '/EcoRide';
?>

<div class="container">
    <section class="my-5 p-4 bg-white rounded-3 shadow-sm" style="max-width: 500px; margin: auto;">
        <h1 class="text-center mb-4">Connexion</h1>
        <p class="text-center lead">Connectez-vous à votre compte EcoRide.</p>

        <form action="<?php echo $base_url; ?>/backend/login" method="POST"> <div class="mb-3">
                <label for="email" class="form-label">Adresse email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="d-grid gap-2 mt-4">
                <button type="submit" class="btn btn-primary btn-lg">Se connecter</button>
            </div>
        </form>

        <p class="text-center mt-3">
            Pas encore de compte ? <a href="<?php echo $base_url; ?>/signin">Inscrivez-vous ici</a>
        </p>
    </section>
</div>
