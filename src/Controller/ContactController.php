<?php
// Ce contrôleur gère le traitement du formulaire de contact.

namespace App\Controller;

// Note: DbConnection n'est pas directement utilisé ici, mais serait pour stocker les messages.
// Pour l'instant, on simule juste l'envoi.

$messageType = 'info';
$messageTitle = '';
$messageContent = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name'] ?? '');
    $email = htmlspecialchars($_POST['email'] ?? '');
    $subject = htmlspecialchars($_POST['subject'] ?? '');
    $message = htmlspecialchars($_POST['message'] ?? '');

    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        $messageType = 'danger';
        $messageTitle = 'Erreur d\'envoi :';
        $messageContent[] = "Tous les champs du formulaire de contact sont requis.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $messageType = 'danger';
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
    $messageType = 'info';
    $messageTitle = 'Information :';
    $messageContent[] = "Ce fichier est destiné au traitement du formulaire de contact. Accédez-y via le formulaire.";
}

// Stocke les messages dans la session pour les afficher sur la page de contact
$_SESSION['contact_form_message_type'] = $messageType;
$_SESSION['contact_form_message_title'] = $messageTitle;
$_SESSION['contact_form_message_content'] = $messageContent;

header('Location: /contact'); // Redirige vers la page de contact
exit();
