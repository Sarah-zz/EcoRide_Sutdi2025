<?php
// src/Controller/UserDashboardController.php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Entity\User;
use PDOException;
use Exception;


if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Vérification de l'authentification
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || !isset($_SESSION['user_id'])) {
    $_SESSION['login_message_type'] = 'danger';
    $_SESSION['login_message_title'] = 'Accès refusé :';
    $_SESSION['login_message_content'] = ['Veuillez vous connecter pour accéder à votre tableau de bord.'];
    header('Location: ' . $base_url . '/login');
    exit();
}

$user = null;
$data = [];

try {
    $userRepository = new UserRepository();
    $user = $userRepository->getUserById($_SESSION['user_id']);

    if ($user) {
        $data = [
        'userPseudo' => $user->getPseudo(),
        'userEmail' => $user->getEmail(),
        'userFirstName' => $user->getFirstName(),
        'userLastName' => $user->getLastName(),
        'userPhone' => $user->getPhone(),
        'userCredits' => $user->getCredits(),
        'userProfilePicture' => $user->getProfilePicture(),
        'userRating' => $user->getRating(),
        'userRoleId' => $user->getRole(),
        'userRoleName' => User::ROLE_NAMES[$user->getRole()] ?? 'Inconnu',
        'isDriver' => $user->getIsDriver(),
        'isPassenger' => $user->getIsPassenger(),
        'userId' => $user->getId(),
        'base_url' => $base_url,
        ];
        
        $data['messageType'] = $_SESSION['login_message_type'] ?? '';
        $data['messageTitle'] = $_SESSION['login_message_title'] ?? '';
        $data['messageContent'] = $_SESSION['login_message_content'] ?? [];

        unset($_SESSION['login_message_type']);
        unset($_SESSION['login_message_title']);
        unset($_SESSION['login_message_content']);

    } else {
        error_log("Tentative d'accès au dashboard avec un ID utilisateur inexistant : " . $_SESSION['user_id']);
        session_destroy();
        $_SESSION['login_message_type'] = 'danger';
        $_SESSION['login_message_title'] = 'Session invalide :';
        $_SESSION['login_message_content'] = ['Vos informations de session sont invalides. Veuillez vous reconnecter.'];
        header('Location: ' . $base_url . '/login');
        exit();
    }
} catch (PDOException $e) {
    error_log("Erreur PDO dans UserDashboardController : " . $e->getMessage());
    $_SESSION['login_message_type'] = 'danger';
    $_SESSION['login_message_title'] = 'Erreur système :';
    $_SESSION['login_message_content'] = ['Une erreur de base de données est survenue lors du chargement de votre tableau de bord. Veuillez réessayer plus tard.'];
    header('Location: ' . $base_url . '/login');
    exit();
} catch (Exception $e) {
    error_log("Erreur inattendue dans UserDashboardController : " . $e->getMessage());
    $_SESSION['login_message_type'] = 'danger';
    $_SESSION['login_message_title'] = 'Erreur :';
    $_SESSION['login_message_content'] = ['Une erreur inattendue est survenue lors du chargement de votre tableau de bord.'];
    header('Location: ' . $base_url . '/login');
    exit();
}

// --- REMPLACEZ LA LIGNE 83 ICI ---
$pathToView = __DIR__ . '/../src/View/userdashboard.php'; // C'est le chemin actuel que vous utilisez

echo "<pre>DEBUG: Le contrôleur cherche la vue à ce chemin : " . $pathToView . "</pre>";

if (!file_exists($pathToView)) {
    echo "<pre>ERREUR CRITIQUE: Le fichier de vue N'EXISTE PAS à l'emplacement indiqué !</pre>";
    // Ajoutez ici des infos pour vous aider à déboguer le chemin
    echo "<pre>DEBUG: __DIR__ (du contrôleur) est : " . __DIR__ . "</pre>";
    echo "<pre>DEBUG: Contenu de src/ (liste des dossiers) :";
    exec('ls -l ' . __DIR__ . '/../src/', $output); // Liste les contenus de src/
    print_r($output);
    $output = [];
    echo "</pre>";

    echo "<pre>DEBUG: Contenu du dossier View/ (ou celui que vous utilisez) :";
    exec('ls -l ' . __DIR__ . '/../src/View/', $output); // Liste les contenus de src/View/
    print_r($output);
    echo "</pre>";

    die("Arrêt du script : Impossible de trouver la vue userdashboard.php."); // Arrête l'exécution
}

require_once $pathToView; // Exécute l'inclusion si le fichier est trouvé
exit();