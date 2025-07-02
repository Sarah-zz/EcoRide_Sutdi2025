<?php

namespace App\Controller;

use App\Repository\UserRepository;
use PDOException;
use Exception;

if (!isset($base_url)) {
    header('Location: /error_fatal.php');
    exit();
}

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || !isset($_SESSION['user_id'])) {
    $_SESSION['login_message_type'] = 'danger';
    $_SESSION['login_message_title'] = 'Accès refusé :';
    $_SESSION['login_message_content'] = ['Veuillez vous connecter pour accéder à cette fonctionnalité.'];
    header('Location: ' . $base_url . '/login');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_SESSION['user_id'];

    $isDriver = isset($_POST['isDriver']) && $_POST['isDriver'] == '1' ? true : false;

    $isPassenger = true;

    try {
        $userRepository = new UserRepository();
        $user = $userRepository->getUserById($userId);

        if ($user) {
            $user->setIsDriver($isDriver);
            $user->setIsPassenger($isPassenger);

            if ($userRepository->updateUser($user)) {
                $_SESSION['user_is_driver'] = $isDriver;
                $_SESSION['user_is_passenger'] = $isPassenger;

                $_SESSION['login_message_type'] = 'success';
                $_SESSION['login_message_title'] = 'Rôles mis à jour :';
                $_SESSION['login_message_content'] = ['Vos préférences de rôle ont été enregistrées avec succès.'];
            } else {
                $_SESSION['login_message_type'] = 'danger';
                $_SESSION['login_message_title'] = 'Erreur :';
                $_SESSION['login_message_content'] = ['Impossible d\'enregistrer vos préférences de rôle. Une erreur est survenue lors de la mise à jour.'];
            }
        } else {
            $_SESSION['login_message_type'] = 'danger';
            $_SESSION['login_message_title'] = 'Erreur :';
            $_SESSION['login_message_content'] = ['Utilisateur introuvable. Veuillez vous reconnecter.'];
        }
    } catch (PDOException $e) {
        $_SESSION['login_message_type'] = 'danger';
        $_SESSION['login_message_title'] = 'Erreur système :';
        $_SESSION['login_message_content'] = ['Une erreur de base de données est survenue. Veuillez réessayer plus tard.'];
    } catch (Exception $e) {
        $_SESSION['login_message_type'] = 'danger';
        $_SESSION['login_message_title'] = 'Erreur :';
        $_SESSION['login_message_content'] = ['Une erreur inattendue est survenue. Veuillez contacter le support.'];
    }
} else {
    $_SESSION['login_message_type'] = 'info';
    $_SESSION['login_message_title'] = 'Information :';
    $_SESSION['login_message_content'] = ['Veuillez utiliser le formulaire de votre tableau de bord pour mettre à jour vos rôles.'];
}

$redirectPath = $base_url . '/dashboard';

header('Location: ' . $redirectPath);
exit();
