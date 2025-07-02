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
