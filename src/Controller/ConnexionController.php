<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Entity\User;
use PDOException;

// --- Logique de connexion (Login) ---
$messageType = 'danger';
$messageTitle = 'Erreur de connexion :';
$messageContent = ['Une erreur inattendue est survenue. Veuillez réessayer.'];
$redirectPath = $base_url . '/';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = htmlspecialchars(trim($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $messageContent = ["Veuillez saisir votre email et votre mot de passe."];
    } else {
        $userRepository = new UserRepository();

        try {
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
                $_SESSION['user_role_name'] = User::ROLE_NAMES[$user->getRole()] ?? 'Refusé';


                $messageType = 'success';
                $messageTitle = 'Connexion réussie !';
                $messageContent = ["Bienvenue, " . $user->getPseudo() . " !"];

                $userRoleId = $user->getRole(); 
                if ($userRoleId == 1) {
                    $redirectPath = $base_url . '/dashboard';
                } elseif ($userRoleId == 2) {
                    $redirectPath = $base_url . '/employedashboard';
                } elseif ($userRoleId == 3) {
                    $redirectPath = $base_url . '/admindashboard';
                } else {
                    $redirectPath = $base_url . '/dashboard';
                }

            } else {
                $_SESSION['logged_in'] = false;
                $messageContent = ["Adresse email ou mot de passe incorrect."];
            }
        } catch (PDOException $e) {
            $messageContent = ["Une erreur est survenue lors de la connexion. Veuillez réessayer plus tard. Détails (pour le développement) : " . $e->getMessage()];
        } catch (\Exception $e) {
            $messageContent = ["Une erreur inattendue est survenue. Détails (pour le développement) : " . $e->getMessage()];
        }
    }

    $_SESSION['login_message_type'] = $messageType;
    $_SESSION['login_message_title'] = $messageTitle;
    $_SESSION['login_message_content'] = $messageContent;


    header('Location: ' . $redirectPath);
    exit();

} elseif ($requestUri === '') {

    // --- Logique de déconnexion (Logout) ---

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