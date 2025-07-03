<div class="container">
    <?php
    if (!isset($user) || !($user instanceof \App\Entity\User)) {
        echo '<div class="alert alert-danger" role="alert">Erreur : Les informations utilisateur ne sont pas disponibles.</div>';
        return;
    }
    ?>

    <h1 class="text-center mb-4">Bienvenue, <?php echo htmlspecialchars($user->getPseudo()); ?> !</h1>

    <?php if (isset($messageType) && $messageType && !empty($messageContent)): ?>
        <div class="alert alert-<?php echo htmlspecialchars($messageType); ?> shadow-sm" role="alert">
            <?php if (isset($messageTitle) && !empty($messageTitle)): ?>
                <h4 class="alert-heading"><?php echo htmlspecialchars($messageTitle); ?></h4>
            <?php endif; ?>
            <?php foreach ($messageContent as $msg): ?>
                <p class="mb-0"><?php echo htmlspecialchars($msg); ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <p class="text-center text-muted mb-5">Voici vos informations personnelles et le résumé de votre compte.</p>

    <div class="d-flex flex-column align-items-center mb-5">
        <img src="<?php echo htmlspecialchars($base_url); ?>/assets/images/<?php echo htmlspecialchars($user->getProfilePicture()); ?>" alt="Photo de profil" class="mb-3">
        <h2 class="h4 mb-1"><?php echo htmlspecialchars($user->getFirstName() . ' ' . $user->getLastName()); ?></h2>
        <p class="text-muted">@<?php echo htmlspecialchars($user->getPseudo()); ?></p>
    </div>

    <h2 class="h5 pb-2 mb-4 border-bottom">Détails du compte</h2>
    <ul class="list-unstyled mb-5">
        <li><strong>Email :</strong> <span class="text-muted"><?php echo htmlspecialchars($user->getEmail()); ?></span></li>
        <li><strong>Téléphone :</strong> <span class="text-muted"><?php echo htmlspecialchars($user->getPhone() ?? 'Non disponible'); ?></span></li>
        <li><strong>Crédits :</strong> <span class="fw-bold text-primary"><?php echo htmlspecialchars($user->getCredits()); ?></span></li>
        <li><strong>Note :</strong> <span class="text-warning"><?php echo str_repeat('⭐', $user->getRating()); ?></span> (<?php echo htmlspecialchars($user->getRating()); ?>/5)</li>
        <li>
            <strong>Rôle(s) :</strong>
            <div class="mt-2">
                <?php foreach ($user->getRoles() as $role): ?>
                    <span class="badge bg-info text-dark"><?php echo htmlspecialchars(ucfirst($role)); ?></span>
                <?php endforeach; ?>
            </div>
        </li>
        <li>
            <strong>Statut :</strong>
            <span class="<?php echo $user->getIsDriver() ? 'text-success fw-bold' : 'text-muted'; ?>">
                <?php echo $user->getIsDriver() ? 'Chauffeur' : ''; ?>
            </span>
            <span class="<?php echo $user->getIsPassenger() ? 'text-success fw-bold' : 'text-muted'; ?>">
                <?php echo $user->getIsPassenger() ? ($user->getIsDriver() ? ' & Passager' : 'Passager') : ''; ?>
            </span>
        </li>
    </ul>

    <hr class="my-5">

    <form action="<?php echo htmlspecialchars($base_url); ?>/userdashboard" method="POST" class="mb-5">
        <h3 class="h5 mb-4">Configurez vos rôles :</h3>
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" id="isPassenger" name="isPassenger" value="1" checked disabled>
            <label class="form-check-label" for="isPassenger">
                Je suis un **Passager** (rôle par défaut)
            </label>
            <input type="hidden" name="isPassenger" value="1">
        </div>
        <div class="form-check mb-4">
            <input class="form-check-input" type="checkbox" id="isDriver" name="isDriver" value="1" <?php echo $user->getIsDriver() ? 'checked' : ''; ?>>
            <label class="form-check-label" for="isDriver">
                Je suis un **Chauffeur**
            </label>
        </div>
        <input type="hidden" name="action" value="update_roles">
        <button type="submit" class="btn btn-primary shadow-sm">Enregistrer mes rôles</button>
    </form>

    <div id="driverPassengerOptions" class="mb-5">
        <h4 class="h5 mb-4">Mes options :</h4>
        <?php if ($user->getIsDriver()): ?>
            <p class="text-muted mb-4">Vous avez sélectionné **Chauffeur** et vous êtes également **Passager**.</p>
            <ul class="list-unstyled">
                <li class="mb-2"><a href="<?php echo htmlspecialchars($base_url); ?>/backend/driver/preferences" class="text-decoration-none">Gérer mes préférences de conduite</a></li>
                <li class="mb-2"><a href="#" class="text-decoration-none">Proposer un trajet</a></li>
                <li class="mb-2"><a href="#" class="text-decoration-none">Mes trajets proposés</a></li>
                <li class="mb-2"><a href="<?php echo htmlspecialchars($base_url); ?>/covoiturage" class="text-decoration-none">Rechercher un covoiturage</a></li>
                <li class="mb-2"><a href="#" class="text-decoration-none">Mes réservations</a></li>
                <li class="mb-2"><a href="#" class="text-decoration-none">Mes demandes de réservation</a></li>
            </ul>
        <?php else: ?>
            <p class="text-muted mb-4">Vous avez sélectionné **Passager**.</p>
            <ul class="list-unstyled">
                <li class="mb-2"><a href="<?php echo htmlspecialchars($base_url); ?>/covoiturage" class="text-decoration-none">Rechercher un covoiturage</a></li>
                <li class="mb-2"><a href="#" class="text-decoration-none">Mes réservations</a></li>
                <li class="mb-2"><a href="#" class="text-decoration-none">Mes demandes de réservation</a></li>
            </ul>
        <?php endif; ?>
    </div>

    <hr class="my-5">

    <div class="text-center">
        <a href="<?php echo htmlspecialchars($base_url); ?>/logout" class="btn btn-danger">Déconnexion</a>
    </div>

    <hr class="my-5">

    <div class="bg-light p-4 rounded mt-5">
        <h2 class="h5 mb-3">Contenu complet de la session (Débogage) :</h2>
        <pre class="bg-white p-3 rounded border overflow-auto" style="max-height: 200px;"><?php var_dump($_SESSION); ?></pre>
    </div>
</div>
