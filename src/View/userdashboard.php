<?php

if (!isset($data) || !is_array($data)) {
    $data = [];
}

$userPseudo = $data['userPseudo'] ?? 'Utilisateur';
$userEmail = $data['userEmail'] ?? 'Non disponible';
$userFirstName = $data['userFirstName'] ?? 'Non disponible';
$userLastName = $data['userLastName'] ?? 'Non disponible';
$userPhone = $data['userPhone'] ?? 'Non disponible';
$userCredits = $data['userCredits'] ?? 0;
$userProfilePicture = $data['userProfilePicture'] ?? 'default_profile.png';
$userRating = $data['userRating'] ?? 0;
$userRoleId = $data['userRoleId'] ?? 0;
$userRoleName = $data['userRoleName'] ?? 'Non disponible';

$isDriver = $data['isDriver'] ?? false;
$isPassenger = $data['isPassenger'] ?? true;

$messageType = $data['messageType'] ?? '';
$messageTitle = $data['messageTitle'] ?? '';
$messageContent = $data['messageContent'] ?? [];

$base_url = $data['base_url'] ?? '/';

$userId = $data['userId'] ?? null;
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Tableau de Bord</title>
</head>

<body>
    <div class="container">
        <h1>Bienvenue, <?php echo htmlspecialchars($userPseudo); ?> !</h1>

        <?php if ($messageType && !empty($messageContent)): ?>
            <div class="alert alert-<?php echo htmlspecialchars($messageType); ?>">
                <?php if (!empty($messageTitle)): ?>
                    <strong><?php echo htmlspecialchars($messageTitle); ?></strong><br>
                <?php endif; ?>
                <?php foreach ($messageContent as $msg): ?>
                    <p><?php echo htmlspecialchars($msg); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <p>Voici vos informations personnelles et le résumé de votre compte.</p>

        <div>
            <img src="<?php echo htmlspecialchars($base_url); ?>/assets/images/<?php echo htmlspecialchars($userProfilePicture); ?>" alt="Photo de profil" style="width:100px;height:100px;">
        </div>

        <h2>Détails du compte</h2>
        <ul>
            <li><strong>Pseudo :</strong> <?php echo htmlspecialchars($userPseudo); ?></li>
            <li><strong>Email :</strong> <?php echo htmlspecialchars($userEmail); ?></li>
            <li><strong>Prénom :</strong> <?php echo htmlspecialchars($userFirstName); ?></li>
            <li><strong>Nom :</strong> <?php echo htmlspecialchars($userLastName); ?></li>
            <li><strong>Téléphone :</strong> <?php echo htmlspecialchars($userPhone); ?></li>
            <li><strong>Crédits :</strong> <?php echo htmlspecialchars($userCredits); ?></li>
            <li><strong>Note :</strong> <?php echo htmlspecialchars($userRating); ?>/5</li>
            <?php if ($userRoleId == 2 || $userRoleId == 3) : ?>
                <li><strong>Rôle :</strong> <?php echo htmlspecialchars($userRoleName); ?></li>
            <?php endif; ?>
            <li><strong>Statut :</strong> <?php echo $isDriver ? 'Chauffeur & Passager' : 'Passager'; ?></li>
        </ul>

        <hr>

        <form action="<?php echo htmlspecialchars($base_url); ?>/backend/save_user_roles" method="POST">
            <h3>Configurez vos rôles :</h3>
            <label>
                <input type="checkbox" id="isPassenger" name="isPassenger" value="1" checked disabled>
                Je suis un **Passager** (rôle par défaut)
                <input type="hidden" name="isPassenger" value="1">
            </label><br>
            <label>
                <input type="checkbox" id="isDriver" name="isDriver" value="1" <?php echo $isDriver ? 'checked' : ''; ?>>
                Je suis un **Chauffeur**
            </label><br><br>
            <button type="submit">Enregistrer mes rôles</button>
        </form>

        <div id="driverPassengerOptions">
            <h4>Mes options :</h4>
            <?php if ($isDriver): ?>
                <p>Vous avez sélectionné **Chauffeur** et vous êtes également **Passager**.</p>
                <ul>
                    <li><a href="<?php echo htmlspecialchars($base_url); ?>/backend/driver/preferences">Gérer mes préférences de conduite</a></li>
                    <li><a href="#">Proposer un trajet</a></li>
                    <li><a href="#">Mes trajets proposés</a></li>
                    <li><a href="<?php echo htmlspecialchars($base_url); ?>/covoiturage">Rechercher un covoiturage</a></li>
                    <li><a href="#">Mes réservations</a></li>
                    <li><a href="#">Mes demandes de réservation</a></li>
                </ul>
            <?php else: ?>
                <p>Vous avez sélectionné **Passager**.</p>
                <ul>
                    <li><a href="<?php echo htmlspecialchars($base_url); ?>/covoiturage">Rechercher un covoiturage</a></li>
                    <li><a href="#">Mes réservations</a></li>
                    <li><a href="#">Mes demandes de réservation</a></li>
                </ul>
            <?php endif; ?>
        </div>

        <hr>

        <div>
            <a href="<?php echo htmlspecialchars($base_url); ?>/logout">Déconnexion</a>
        </div>
    </div>

    <hr>
    <div>
        <h2>Contenu complet de la session (Débogage) :</h2>
        <pre><?php var_dump($_SESSION); ?></pre>
    </div>
</body>

</html>