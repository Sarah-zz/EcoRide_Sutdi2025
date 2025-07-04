<?php
$messageType = $_SESSION['form_message_type'] ?? '';
$messageTitle = $_SESSION['form_message_title'] ?? '';
$messageContent = $_SESSION['form_message_content'] ?? [];

unset($_SESSION['form_message_type']);
unset($_SESSION['form_message_title']);
unset($_SESSION['form_message_content']);

?>

<div class="container my-5">
    <section class="bg-white p-4 rounded-3 shadow-sm text-center">
        <?php if (!empty($messageType)): ?>
            <div class="alert alert-<?php echo htmlspecialchars($messageType); ?> text-center" role="alert">
                <?php if (!empty($messageTitle)): ?>
                    <h4 class="alert-heading"><?php echo htmlspecialchars($messageTitle); ?></h4>
                <?php endif; ?>
                <?php foreach ($messageContent as $line): ?>
                    <p class="mb-0"><?php echo $line; ?></p>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-info text-center" role="alert">
                <p>Aucun message à afficher. Vous avez peut-être accédé à cette page directement.</p>
            </div>
        <?php endif; ?>

        <div class="text-center mt-4">
            <a href="<?php echo $base_url; ?>/login" class="btn btn-primary btn-lg">Se connecter maintenant</a>
            <a href="<?php echo $base_url; ?>/" class="btn btn-primary btn-lg ms-3">Retour à l'accueil</a>
        </div>
    </section>
</div>