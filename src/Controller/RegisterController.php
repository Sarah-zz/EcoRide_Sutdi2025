<?php
// src/Controller/RegisterController.php
// Ce contrôleur gère le traitement du formulaire d'inscription.

namespace App\Controller; // <--- AJOUTER CETTE LIGNE

use App\Model\User; // <--- AJOUTER CETTE LIGNE pour utiliser la classe User
use PDOException; // Ajouter si vous utilisez PDOException directement dans le try-catch

$messageType = 'info';
$messageTitle = '';
$messageContent = [];

// Fonction de validation du mot de passe (peut être déplacée dans une classe de validation)
function isPasswordSecure($password) {
    if (strlen($password) < 8) return false;
    if (!preg_match('/[A-Z]/', $password)) return false;
    if (!preg_match('/[a-z]/', $password)) return false;
    if (!preg_match('/[0-9]/', $password)) return false;
    if (!preg_match('/[^a-zA-Z0-9]/', $password)) return false;
    return true;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer et nettoyer les données du formulaire
    $pseudo = htmlspecialchars($_POST['pseudo'] ?? '');
    $firstName = htmlspecialchars($_POST['first_name'] ?? '');
    $lastName = htmlspecialchars($_POST['last_name'] ?? '');
    $email = htmlspecialchars($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
    $profilePicture = htmlspecialchars($_POST['profile_picture'] ?? 'default_profile.png');

    // --- Validation des données du formulaire ---
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
    } elseif (!isPasswordSecure($password)) {
        $messageContent[] = "Le mot de passe n'est pas sécurisé. Il doit contenir au moins 8 caractères, dont une majuscule, une minuscule, un chiffre et un caractère spécial.";
    }
    if ($password !== $confirmPassword) {
        $messageContent[] = "Les mots de passe ne correspondent pas.";
    }

    if (empty($messageContent)) {
        $userModel = new User(); // Instancie le Modèle User (grâce au 'use' statement)

        try {
            // Vérifier si l'email ou le pseudo existe déjà
            if ($userModel->emailOrPseudoExists($email, $pseudo)) {
                $messageType = 'danger';
                $messageTitle = 'Erreur(s) d\'inscription :';
                $messageContent[] = "Cet email ou pseudo est déjà utilisé. Veuillez en choisir un autre.";
            } else {
                $initialCredits = 20;
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                // Appelle la méthode du Modèle pour enregistrer l'utilisateur
                $registrationSuccess = $userModel->registerUser(
                    $pseudo,
                    $firstName,
                    $lastName,
                    $email,
                    $hashedPassword,
                    $initialCredits,
                    $profilePicture
                );

                if ($registrationSuccess) {
                    $messageType = 'success';
                    $messageTitle = 'Inscription réussie !';
                    $messageContent[] = "Bienvenue, <strong>" . $pseudo . "</strong> !";
                    $messageContent[] = "Votre email : " . $email;
                    $messageContent[] = "Vous avez été crédité de <strong>" . $initialCredits . "</strong> points pour commencer.";
                    $messageContent[] = "Votre photo de profil : " . $profilePicture;
                    $messageContent[] = "<hr><p class='mb-0'>Vous pouvez maintenant vous connecter à votre compte.</p>";
                } else {
                    $messageType = 'danger';
                    $messageTitle = 'Erreur(s) d\'inscription :';
                    $messageContent[] = "Une erreur inconnue est survenue lors de l'enregistrement de votre compte.";
                }
            }
        } catch (PDOException $e) {
            $messageType = 'danger';
            $messageTitle = 'Erreur(s) d\'inscription :';
            $messageContent[] = "Une erreur est survenue lors de l'enregistrement de votre compte. Veuillez réessayer plus tard. (" . $e->getMessage() . ")";
        }
    }
} else {
    $messageTitle = 'Information :';
    $messageContent[] = "Ce fichier est destiné au traitement du formulaire d'inscription. Accédez-y via le formulaire.";
}

// Stocke les messages dans la session pour les afficher sur la page d'inscription
$_SESSION['form_message_type'] = $messageType;
$_SESSION['form_message_title'] = $messageTitle;
$_SESSION['form_message_content'] = $messageContent;

header('Location: /signin'); // Redirige vers la page d'inscription (chemin absolu)
exit();
