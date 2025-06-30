<?php
$userPseudo = $_SESSION['user_pseudo'] ?? 'Utilisateur';
$userEmail = $_SESSION['user_email'] ?? 'Non disponible';
$userFirstName = $_SESSION['user_firstname'] ?? 'Non disponible';
$userLastName = $_SESSION['user_lastname'] ?? 'Non disponible';
$userPhone = $_SESSION['user_phone'] ?? 'Non disponible';
$userCredits = $_SESSION['user_credits'] ?? 0;
$userProfilePicture = $_SESSION['user_profile_picture'] ?? 'default_profile.png';
$userRating = $_SESSION['user_rating'] ?? 0;
$userRoleId = $_SESSION['user_role_id'] ?? 0;
$userRoleName = $_SESSION['user_role_name'] ?? 'Non disponible';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Utilisateur</title>
    </head>
<body>
    <section class="container">
        <h1 class="display-4 mb-4">
            Bienvenue, <?php echo htmlspecialchars($userPseudo); ?> !
        </h1>

        <p>
            Voici vos informations personnelles et le résumé de votre compte.
        </p>

        <h2>Détails du compte</h2>
        <ul>
            <li><strong>Pseudo :</strong> <?php echo htmlspecialchars($userPseudo); ?></li>
            <li><strong>Email :</strong> <?php echo htmlspecialchars($userEmail); ?></li>
            <li><strong>Prénom :</strong> <?php echo htmlspecialchars($userFirstName); ?></li>
            <li><strong>Nom :</strong> <?php echo htmlspecialchars($userLastName); ?></li>
            <li><strong>Téléphone :</strong> <?php echo htmlspecialchars($userPhone); ?></li>
            <li><strong>Crédits :</strong> <?php echo htmlspecialchars($userCredits); ?></li>
            <li><strong>Note :</strong> <?php echo htmlspecialchars($userRating); ?></li>
            <?php
            if ($userRoleId == 2 || $userRoleId == 3) :
            ?>
                <li><strong>Rôle :</strong> <?php echo htmlspecialchars($userRoleName); ?></li>
            <?php endif; ?>
            </ul>

        <div>
            <a href="<?php echo $base_url; ?>/backend/logout" class="btn btn-primary btn-lg ms-3">Déconnexion</a>
        </div>
    </section>

    <hr>
    <h2>Contenu complet de la session (Débogage) :</h2>
    <pre>
<?php
var_dump($_SESSION);
?>
    </pre>
</body>
</html>