<?php
// src/View/signin.php
// Cette page contient le formulaire d'inscription pour les nouveaux utilisateurs.
// Elle est incluse par public/index.php.

// Récupère les messages du contrôleur RegisterController via la session
$messageType = $_SESSION['form_message_type'] ?? '';
$messageTitle = $_SESSION['form_message_title'] ?? '';
$messageContent = $_SESSION['form_message_content'] ?? [];

// Efface les messages de la session après les avoir récupérés
unset($_SESSION['form_message_type']);
unset($_SESSION['form_message_title']);
unset($_SESSION['form_message_content']);

$base_url = '/EcoRide'; // <--- IMPORTANT: Adaptez ce chemin si votre dossier de projet est différent
?>

<style>
    /* Styles spécifiques pour la page d'inscription */
    .registration-section {
        background-color: #ffffff;
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        padding: 40px;
        margin-top: 50px;
        margin-bottom: 50px;
        max-width: 600px; /* Limite la largeur du formulaire */
        margin-left: auto;
        margin-right: auto;
    }
    .registration-section .form-control {
        border-radius: 8px;
        padding: 12px 15px;
        border: 1px solid #ced4da;
    }
    .registration-section .btn-primary {
        background-color: var(--color-primary-green); /* Utilise la couleur verte écologique */
        border-color: var(--color-primary-green);
        padding: 12px 30px;
        border-radius: 8px;
        font-weight: bold;
        transition: background-color 0.3s ease;
    }
    .registration-section .btn-primary:hover {
        background-color: var(--color-dark-accent); /* Vert plus foncé au survol */
        border-color: var(--color-dark-accent);
    }
    /* Styles pour les messages d'erreur/succès */
    .alert-success { border-radius: 8px; }
    .alert-danger { border-radius: 8px; }
    .alert-info { border-radius: 8px; }
</style>

<div class="container">
    <section class="registration-section">
        <h1 class="text-center mb-4">Rejoignez la communauté EcoRide !</h1>
        <p class="lead text-center mb-5">
            Inscrivez-vous gratuitement et commencez à voyager de manière plus écologique et économique.
        </p>

        <?php if (!empty($messageType)): ?>
            <div class="alert alert-<?php echo htmlspecialchars($messageType); ?> text-center" role="alert">
                <?php if (!empty($messageTitle)): ?>
                    <h4 class="alert-heading"><?php echo htmlspecialchars($messageTitle); ?></h4>
                <?php endif; ?>
                <?php if ($messageType === 'danger'): ?>
                    <ul>
                        <?php foreach ($messageContent as $line): ?>
                            <li><?php echo $line; ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <?php foreach ($messageContent as $line): ?>
                        <p><?php echo $line; ?></p>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <form action="<?php echo $base_url; ?>/backend/register" method="POST"> <div class="mb-3">
                <label for="pseudo" class="form-label">Pseudo</label>
                <input type="text" class="form-control" id="pseudo" name="pseudo" required>
            </div>
            <div class="mb-3">
                <label for="firstName" class="form-label">Prénom</label>
                <input type="text" class="form-control" id="firstName" name="first_name" required>
            </div>
            <div class="mb-3">
                <label for="lastName" class="form-label">Nom</label>
                <input type="text" class="form-control" id="lastName" name="last_name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Adresse email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" class="form-control" id="password" name="password" required>
                <small id="passwordHelp" class="form-text text-muted">Au moins 8 caractères, incluant une majuscule, une minuscule, un chiffre et un caractère spécial.</small>
            </div>
            <div class="mb-3">
                <label for="confirmPassword" class="form-label">Confirmer le mot de passe</label>
                <input type="password" class="form-control" id="confirmPassword" name="confirm_password" required>
            </div>
            <div class="d-grid gap-2 mt-4">
                <button type="submit" class="btn btn-primary btn-lg">S'inscrire</button>
            </div>
        </form>

        <p class="text-center mt-3">
            Déjà un compte ? <a href="<?php echo $base_url; ?>/login">Connectez-vous ici</a>
        </p>
    </section>
</div>
