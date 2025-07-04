<?php
// Ce contrôleur gère le traitement du formulaire de contact.

namespace App\Controller;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name'] ?? '');
    $email = htmlspecialchars($_POST['email'] ?? '');
    $subject = htmlspecialchars($_POST['subject'] ?? '');
    $message = htmlspecialchars($_POST['message'] ?? '');

    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        $messageTitle = 'Erreur d\'envoi :';
        $messageContent[] = "Tous les champs du formulaire de contact sont requis.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $messageTitle = 'Erreur d\'envoi :';
        $messageContent[] = "L'adresse email n'est pas valide.";
    } else {
        // Prchaine étape : implémenter logique d'envoi de l'email ou de stockage en base de données.
        // Simulation du succès
        $messageType = 'success';
        $messageTitle = 'Message envoyé !';
        $messageContent[] = "Merci <strong>" . $name . "</strong>, votre message a été envoyé avec succès.";
        $messageContent[] = "Nous vous répondrons à l'adresse <strong>" . $email . "</strong> dans les plus brefs délais.";
    }
} else {
}

// Stocke les messages dans la session pour les afficher sur la page de contact
$_SESSION['contact_form_message_type'] = $messageType;
$_SESSION['contact_form_message_title'] = $messageTitle;
$_SESSION['contact_form_message_content'] = $messageContent;

header('Location: ' . $base_url . '/contact_reponse');
exit();
