<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: ' . ($base_url ?? '') . '/login');
    exit();
}


$userId = $userData['id'] ?? 'Non disponible';
$userPseudo = $userData['pseudo'] ?? 'Utilisateur';
$userEmail = $userData['email'] ?? 'Non disponible';
$userFirstName = $userData['firstname'] ?? 'Non disponible';
$userLastName = $userData['lastname'] ?? 'Non disponible';

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord</title>
</head>
<body>
    <section  class = container>
    <h1 class = display-4 mb-4>
        Bienvenue, <?php echo htmlspecialchars($userPseudo); ?> !
    </h1>

    <p>
        Voici vos informations personnelles et le résumé de votre compte.
    </p>

    <h2>Détails du compte</h2>
    <ul>
        <li><strong>ID Utilisateur :</strong> <?php echo htmlspecialchars($userId); ?></li>
        <li><strong>Pseudo :</strong> <?php echo htmlspecialchars($userPseudo); ?></li>
        <li><strong>Email :</strong> <?php echo htmlspecialchars($userEmail); ?></li>
        <li><strong>Prénom :</strong> <?php echo htmlspecialchars($userFirstName); ?></li>
        <li><strong>Nom :</strong> <?php echo htmlspecialchars($userLastName); ?></li>
    </ul>

    <div>
        <a href="<?php echo $base_url; ?>/" class="btn btn-primary btn-lg ms-3">Déconnexion</a>

    </div>
</section>
    <!-- Section de débogage (peut être retirée en production) -->
    <hr>
    <h2>Contenu complet de la session (Débogage) :</h2>
    <pre>
<?php
// Utilisez var_export pour une sortie plus lisible pour les tableaux que var_dump
var_dump($_SESSION);
?>
    </pre>
</body>
</html>
