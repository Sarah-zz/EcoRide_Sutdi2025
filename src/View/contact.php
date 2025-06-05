<?php
// src/View/contact.php
// Cette page contient un formulaire de contact.
// Elle est incluse par public/index.php.

// Récupère les messages du contrôleur ContactController via la session
$messageType = $_SESSION['contact_form_message_type'] ?? '';
$messageTitle = $_SESSION['contact_form_message_title'] ?? '';
$messageContent = $_SESSION['contact_form_message_content'] ?? [];

// Efface les messages de la session après les avoir récupérés
unset($_SESSION['contact_form_message_type']);
unset($_SESSION['contact_form_message_title']);
unset($_SESSION['contact_form_message_content']);

$base_url = '/EcoRide'; // <--- IMPORTANT: Adaptez ce chemin si votre dossier de projet est différent
?>

<style>
    /* Styles spécifiques pour la page de contact */
    /* Ces styles devraient idéalement être dans public/assets/css/contact.css */
    .contact-section {
        background-color: #ffffff;
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        padding: 40px;
        margin-top: 50px;
        margin-bottom: 50px;
        max-width: 700px; /* Limite la largeur du formulaire */
        margin-left: auto;
        margin-right: auto;
    }
    .contact-section .form-control {
        border-radius: 8px;
        padding: 12px 15px;
        border: 1px solid #ced4da;
    }
    .contact-section textarea.form-control {
        min-height: 150px; /* Hauteur minimale pour le champ message */
    }
    .contact-section .btn-primary {
        background-color: var(--color-primary-green); /* Utilise la couleur verte écologique */
        border-color: var(--color-primary-green);
        padding: 12px 30px;
        border-radius: 8px;
        font-weight: bold;
        transition: background-color 0.3s ease;
    }
    .contact-section .btn-primary:hover {
        background-color: var(--color-dark-accent); /* Vert plus foncé au survol */
        border-color: var(--color-dark-accent);
    }
    /* Styles pour les messages d'erreur/succès */
    .alert-success { border-radius: 8px; }
    .alert-danger { border-radius: 8px; }
    .alert-info { border-radius: 8px; }
</style>

<div class="container">
    <section class="contact-section">
        <h1 class="text-center mb-4">Contactez-nous</h1>
        <p class="lead text-center mb-5">
            Vous avez une question, une suggestion ou un problème ? N'hésitez pas à nous envoyer un message !
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

        <form action="<?php echo $base_url; ?>/backend/contact_process" method="POST"> <div class="mb-3">
                <label for="name" class="form-label">Votre Nom</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Votre Adresse Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="subject" class="form-label">Sujet</label>
                <input type="text" class="form-control" id="subject" name="subject" required>
            </div>
            <div class="mb-3">
                <label for="message" class="form-label">Votre Message</label>
                <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
            </div>
            <div class="d-grid gap-2 mt-4">
                <button type="submit" class="btn btn-primary btn-lg">Envoyer le message</button>
            </div>
        </form>

        <p class="text-center mt-4 text-muted">
            Nous nous efforçons de répondre à tous les messages dans les plus brefs délais.
        </p>
    </section>
</div>
