<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Repository\DriverPreferencesRepository;
use App\Entity\User;
use App\Entity\DriverPreferences;
use App\Form\DriverPreferencesForm;
use Exception;

$data = [];

if (!isset($base_url)) {
    error_log("DriverController: \$base_url non défini. Erreur de configuration.");
    http_response_code(500);
    echo "Une erreur de configuration est survenue. Veuillez contacter l'administrateur.";
    exit();
}

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || !isset($_SESSION['user_id'])) {
    $_SESSION['login_message_type'] = 'danger';
    $_SESSION['login_message_title'] = 'Accès refusé :';
    $_SESSION['login_message_content'] = ['Veuillez vous connecter pour gérer vos préférences.'];
    header('Location: ' . $base_url . '/login');
    exit();
}

try {
    $userRepository = new UserRepository();
    $userId = $_SESSION['user_id'];
    $user = $userRepository->getUserById($userId);

    if (!$user || !$user->getIsDriver()) {
        error_log("DriverController: Accès non autorisé. Utilisateur ID " . $userId . " n'est pas trouvé ou n'est pas conducteur.");
        $_SESSION['login_message_type'] = 'danger';
        $_SESSION['login_message_title'] = 'Accès non autorisé :';
        $_SESSION['login_message_content'] = ['Vous devez être un conducteur pour accéder à cette page.'];
        header('Location: ' . $base_url . '/userdashboard');
        exit();
    }

    $driverPreferencesRepository = new DriverPreferencesRepository();

    $preferences = $driverPreferencesRepository->findByUserId($userId);
    if (!$preferences) {
        $preferences = new DriverPreferences(['userId' => $userId]);
    }

    $messageType = '';
    $messageTitle = '';
    $messageContent = [];

    $form = new DriverPreferencesForm($_SERVER['REQUEST_METHOD'] === 'POST' ? $_POST : $preferences->toArray());

    if ($form->isSubmitted() && $form->isValid()) {
        $cleanedData = $form->getData();

        $preferences->setMusicPreference($cleanedData['musicPreference']);
        $preferences->setSmokingAllowed($cleanedData['smokingAllowed']);
        $preferences->setPetAllowed($cleanedData['petAllowed']);
        $preferences->setLuggageSpace($cleanedData['luggageSpace']);
        $preferences->setChatPreference($cleanedData['chatPreference']);

        if ($driverPreferencesRepository->save($preferences)) {
            $messageType = 'success';
            $messageTitle = 'Succès :';
            $messageContent[] = 'Vos préférences de conduite ont été enregistrées.';
            $preferences = $driverPreferencesRepository->findByUserId($userId) ?? $preferences;
        } else {
            $messageType = 'danger';
            $messageTitle = 'Erreur :';
            $messageContent[] = 'Impossible d\'enregistrer vos préférences de conduite.';
        }
    } elseif ($form->isSubmitted() && !$form->isValid()) {
        $messageType = 'danger';
        $messageTitle = 'Erreur de validation :';
        $messageContent = $form->getErrors();
    }

    $data = [
        'user' => $user,
        'preferences' => $preferences,
        'form' => $form,
        'base_url' => $base_url,
        'messageType' => $messageType,
        'messageTitle' => $messageTitle,
        'messageContent' => $messageContent,
    ];
} catch (Exception $e) {
    error_log("DriverController: Erreur inattendue - " . $e->getMessage());
    $_SESSION['login_message_type'] = 'danger';
    $_SESSION['login_message_title'] = 'Erreur système :';
    $_SESSION['login_message_content'] = ['Une erreur est survenue lors du chargement ou de la sauvegarde de vos préférences.'];
    header('Location: ' . $base_url . '/userdashboard');
    exit();
}
