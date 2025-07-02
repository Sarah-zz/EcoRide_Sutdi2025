<?php
// Ce contrôleur gère le traitement du formulaire d'inscription.

namespace App\Controller;

use App\Repository\UserRepository;
use App\Validation\PasswordValid;
use PDOException;
use App\Entity\User;

$messageType = 'info';
$messageTitle = '';
$messageContent = [];
$redirectPath = $base_url . '/signin';


// Vérifie si la requête est une soumission de formulaire POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pseudo = htmlspecialchars(trim($_POST['pseudo'] ?? ''));
    $firstName = htmlspecialchars(trim($_POST['first_name'] ?? ''));
    $lastName = htmlspecialchars(trim($_POST['last_name'] ?? ''));
    $email = htmlspecialchars(trim($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
    $profilePicture = htmlspecialchars(trim($_POST['profile_picture'] ?? 'default_profile.png'));

    if (empty($pseudo)) {
        $messageContent[] = "Le pseudo est requis.";
    }
    if (empty($firstName)) {
        $messageContent[] = "Le prénom est requis.";
    }
    if (empty($lastName)) {
        $messageContent[] = "Le nom est requis.";
    }
    if (empty($email)) {
        $messageContent[] = "L'adresse email est requise.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $messageContent[] = "L'adresse email n'est pas valide.";
    }
    if (empty($password)) {
        $messageContent[] = "Le mot de passe est requis.";
    } elseif (!PasswordValid::isSecure($password)) {
        $messageContent[] = "Le mot de passe n'est pas sécurisé. " . PasswordValid::getSecurityDescription();;
    }
    if ($password !== $confirmPassword) {
        $messageContent[] = "Les mots de passe ne correspondent pas.";
    }

    if (empty($messageContent)) {
        $userRepository = new UserRepository();

        try {
            if ($userRepository->emailOrPseudoExists($email, $pseudo)) {
                $messageContent[] = "Cet email ou pseudo est déjà utilisé. Veuillez en choisir un autre.";
                $messageType = 'danger';
            } else {
                $initialCredits = 20;
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
                $profilePicture = 'default_profile.png';

                $registrationSuccess = $userRepository->registerUser(
                    $pseudo,
                    $firstName,
                    $lastName,
                    $email,
                    $hashedPassword,
                    $initialCredits,
                    $profilePicture,
                    User::ROLE_UTILISATEUR_ID,
                    false,
                    true,
                    false
                );

                if ($registrationSuccess) {
                    $messageType = 'success';
                    $messageTitle = 'Inscription réussie !';
                    $messageContent[] = "Bienvenue, <strong>" . $pseudo . "</strong> !";
                    $messageContent[] = "Votre email : " . $email;
                    $messageContent[] = "Vous avez été crédité de <strong>" . $initialCredits . "</strong> points pour commencer.";
                    $messageContent[] = "<hr><p class='mb-0'>Vous pouvez maintenant vous connecter à votre compte.</p>";
                    $redirectPath = $base_url . '/inscription_reussie';
                } else {
                    $messageType = 'danger';
                    $messageContent[] = "Une erreur inconnue est survenue lors de l'enregistrement de votre compte.";
                }
            }
        } catch (PDOException $e) {
            $messageType = 'danger';
            $messageContent[] = "Une erreur est survenue lors de l'enregistrement de votre compte. Veuillez réessayer plus tard. Détails (pour le développement) : " . $e->getMessage();
        } catch (\Exception $e) {
            $messageType = 'danger';
            $messageContent[] = "Une erreur inattendue est survenue lors du traitement de votre demande. Détails (pour le développement) : " . $e->getMessage();
        }
    }

    if (empty($messageTitle)) {
        $messageTitle = ($messageType === 'danger') ? 'Erreur(s) d\'inscription :' : 'Information :';
    }
} else {
    $messageTitle = 'Information :';
    $messageContent[] = "Veuillez remplir le formulaire pour vous inscrire.";
}

$_SESSION['form_message_type'] = $messageType;
$_SESSION['form_message_title'] = $messageTitle;
$_SESSION['form_message_content'] = $messageContent;

header('Location: ' . $redirectPath);
exit();
