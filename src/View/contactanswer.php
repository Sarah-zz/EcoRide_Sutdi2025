<?php
// Cette page affiche le résultat de la soumission du formulaire de contact.
$messageType = $_SESSION['contact_form_message_type'] ?? '';
$messageTitle = $_SESSION['contact_form_message_title'] ?? '';
$messageContent = $_SESSION['contact_form_message_content'] ?? [];

// Efface les messages de la session après les avoir récupérés
unset($_SESSION['contact_form_message_type']);
unset($_SESSION['contact_form_message_title']);
unset($_SESSION['contact_form_message_content']);
?>

<div class="container search-form-card">
    <section class="">

        <?php if (!empty($messageType)): ?>
            <div class="alert alert-<?php echo htmlspecialchars($messageType); ?> text-center" role="alert">
                <?php if (!empty($messageTitle)): ?>
                    <h4 class="alert-heading"><?php echo htmlspecialchars($messageTitle); ?></h4>
                <?php endif; ?>
                <?php foreach ($messageContent as $line): ?>
                    <p class="mb-0"><?php echo $line; ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="text-center mt-4">
            <a href="<?php echo $base_url; ?>/contact" class="btn btn-secondary btn-lg">Retour au formulaire de contact</a>
            <a href="<?php echo $base_url; ?>/" class="btn btn-secondary btn-lg ms-3">Retour à l'accueil</a>
        </div>
    </section>
</div>