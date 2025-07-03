<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Entity\User;
use PDOException;
use Exception;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Vérification de l'authentification et de la session
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
    $userId = $_SESSION['user_id'];
    $user = $userRepository->getUserById($userId);

    if (!$user) {
        error_log("Tentative d'accès au dashboard avec un ID utilisateur inexistant : " . $userId);
        session_destroy();
        $_SESSION['login_message_type'] = 'danger';
        $_SESSION['login_message_title'] = 'Session invalide :';
        $_SESSION['login_message_content'] = ['Vos informations de session sont invalides. Veuillez vous reconnecter.'];
        header('Location: ' . $base_url . '/login');
        exit();
    }

    // --- LOGIQUE DE TRAITEMENT DES RÔLES (PRÉCÉDEMMENT DANS USERROLESCONTROLLER) ---
    $roleUpdateMessages = [
        'type' => '',
        'title' => '',
        'content' => []
    ];

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_roles') {
        $isDriver = isset($_POST['isDriver']) ? (bool)$_POST['isDriver'] : false;
        $isPassenger = isset($_POST['isPassenger']) ? (bool)$_POST['isPassenger'] : true;

        $user->setIsDriver($isDriver);
        $user->setIsPassenger($isPassenger);

        if ($userRepository->updateUser($user)) {
            $roleUpdateMessages['type'] = 'success';
            $roleUpdateMessages['title'] = 'Mise à jour réussie :';
            $roleUpdateMessages['content'][] = 'Vos rôles ont été mis à jour.';
        } else {
            $roleUpdateMessages['type'] = 'danger';
            $roleUpdateMessages['title'] = 'Erreur de mise à jour :';
            $roleUpdateMessages['content'][] = 'Impossible de mettre à jour vos rôles.';
        }
    }
    // --- FIN TRAITEMENT DES RÔLES ---


    $data = [
        'user' => $user,
        'base_url' => $base_url,
    ];

    if (isset($_SESSION['login_message_type'])) {
        $data['messageType'] = $_SESSION['login_message_type'];
        $data['messageTitle'] = $_SESSION['login_message_title'];
        $data['messageContent'] = $_SESSION['login_message_content'];

        unset($_SESSION['login_message_type']);
        unset($_SESSION['login_message_title']);
        unset($_SESSION['login_message_content']);
    } else {
        $data['messageType'] = '';
        $data['messageTitle'] = '';
        $data['messageContent'] = [];
    }


    if (!empty($roleUpdateMessages['type'])) {
        $data['messageType'] = $roleUpdateMessages['type'];
        $data['messageTitle'] = $roleUpdateMessages['title'];
        if (!isset($data['messageContent']) || !is_array($data['messageContent'])) {
            $data['messageContent'] = [];
        }
        $data['messageContent'] = array_merge($data['messageContent'], $roleUpdateMessages['content']);
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