<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Entity\User;
use PDOException;
use Exception;

if (!isset($base_url)) {
    header('Location: /error_fatal.php');
    exit();
}

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = htmlspecialchars(trim($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';

    $messageType = 'danger';
    $messageTitle = 'Erreur de connexion :';
    $messageContent = ['Une erreur inattendue est survenue. Veuillez réessayer.'];
    $redirectPath = $base_url . '/login';

    if (empty($email) || empty($password)) {
        $messageContent = ["Veuillez saisir votre email et votre mot de passe."];
    } else {
        try {
            $userRepository = new UserRepository();
            $user = $userRepository->getUserByEmail($email);

            if ($user && password_verify($password, $user->getPassword())) {
                $_SESSION['logged_in'] = true;
                $_SESSION['user_id'] = $user->getId();
                $_SESSION['user_pseudo'] = $user->getPseudo();
                $_SESSION['user_email'] = $user->getEmail();
                $_SESSION['user_role_id'] = $user->getRole();
                $_SESSION['user_firstname'] = $user->getFirstName();
                $_SESSION['user_lastname'] = $user->getLastName();
                $_SESSION['user_phone'] = $user->getPhone();
                $_SESSION['user_credits'] = $user->getCredits();
                $_SESSION['user_profile_picture'] = $user->getProfilePicture();
                $_SESSION['user_rating'] = $user->getRating();
                $_SESSION['user_role_name'] = User::ROLE_NAMES[$user->getRole()] ?? 'Inconnu';
                $_SESSION['user_is_driver'] = $user->getIsDriver();
                $_SESSION['user_is_passenger'] = $user->getIsPassenger();

                $messageType = 'success';
                $messageTitle = 'Connexion réussie !';
                $messageContent = ["Bienvenue, " . $user->getPseudo() . " !"];

                if ($user->isAdministrateur()) {
                    $redirectPath = $base_url . '/admindashboard';
                } elseif ($user->isEmploye()) {
                    $redirectPath = $base_url . '/employedashboard';
                } elseif ($user->isUtilisateur()) {
                    $redirectPath = $base_url . '/userdashboard';
                } else {
                    echo 'try again';
                }
            } else {
                $_SESSION['logged_in'] = false;
                $messageContent = ["Adresse email ou mot de passe incorrect."];
            }
        } catch (PDOException $e) {
            error_log("Erreur PDO lors de la connexion : " . $e->getMessage());
            $messageContent = ["Une erreur est survenue lors de la connexion. Veuillez réessayer plus tard."];
        } catch (Exception $e) {
            error_log("Erreur inattendue lors de la connexion : " . $e->getMessage());
            $messageContent = ["Une erreur inattendue est survenue. Veuillez réessayer plus tard."];
        }
    }

    $_SESSION['login_message_type'] = $messageType;
    $_SESSION['login_message_title'] = $messageTitle;
    $_SESSION['login_message_content'] = $messageContent;

    header('Location: ' . $redirectPath);
    exit();
} elseif (isset($requestUri) && $requestUri === 'logout') {

    $_SESSION = array();
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }
    session_destroy();

    header('Location: ' . $base_url . '/');
    exit();
} else {
    http_response_code(400);
    echo "Action non reconnue ou méthode non autorisée.";
    exit();
}
