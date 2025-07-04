<?php
// Cette page contient un formulaire de contact.

$messageType = $_SESSION['contact_form_message_type'] ?? '';
$messageTitle = $_SESSION['contact_form_message_title'] ?? '';
$messageContent = $_SESSION['contact_form_message_content'] ?? [];

unset($_SESSION['contact_form_message_type']);
unset($_SESSION['contact_form_message_title']);
unset($_SESSION['contact_form_message_content']);

?>


<div class="container search-form-card text-center">
    <section class="contact-section bg-light">
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

        <?php
        $formActionPath = $base_url . '/backend/contact_process';
        // Inclusion du formulaire de contact
        include __DIR__ . '/../Form/ContactForm.php';
        ?>

        <p class="text-center mt-4 text-muted">
            Nous nous efforçons de répondre à tous les messages dans les plus brefs délais.
        </p>
    </section>
</div>
