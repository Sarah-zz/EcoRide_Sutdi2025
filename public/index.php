<?php

ob_start();
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Inclure l'autoloader de Composer au tout début
require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// --- Début de la logique du Routeur ---

$basePath = 'EcoRide';
$base_url = '';
if (!empty($basePath)) {
    $base_url = '/' . trim($basePath, '/');
}

$requestUri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
if (!empty($basePath) && strpos($requestUri, trim($basePath, '/')) === 0) {
    $requestUri = substr($requestUri, strlen(trim($basePath, '/')));
    $requestUri = trim($requestUri, '/');
}

$routes = [
    '' => ['type' => 'view', 'cible' => __DIR__ . '/../src/View/welcome.php'],
    'covoiturage' => ['type' => 'view', 'cible' => __DIR__ . '/../src/View/covoiturage.php'],
    'resultats' => ['type' => 'view', 'cible' => __DIR__ . '/../src/View/resultatrecherche.php'],
    'signin' => ['type' => 'view', 'cible' => __DIR__ . '/../src/View/signin.php'],
    'login' => ['type' => 'view', 'cible' => __DIR__ . '/../src/View/login.php'],
    'contact' => ['type' => 'view', 'cible' => __DIR__ . '/../src/View/contact.php'],
    'admin' => ['type' => 'view', 'cible' => __DIR__ . '/../src/View/adminpage.php'],
    'contact_reponse' => ['type' => 'view', 'cible' => __DIR__ . '/../src/View/contactanswer.php'],
    'inscription_reussie' => ['type' => 'view', 'cible' => __DIR__ . '/../src/View/signinsuccess.php'],
    'dashboard' => ['type' => 'view', 'cible' => __DIR__ . '/../src/View/userdashboard.php'],
    // Routes des contrôleurs (pour les traitements backend)
    'backend/recherche' => ['type' => 'controller', 'cible' => __DIR__ . '/../src/Controller/RechercheController.php'],
    'backend/register' => ['type' => 'controller', 'cible' => __DIR__ . '/../src/Controller/RegisterController.php'],
    'backend/contact_process' => ['type' => 'controller', 'cible' => __DIR__ . '/../src/Controller/ContactController.php'],
    'backend/login' => ['type' => 'controller', 'cible' => __DIR__ . '/../src/Controller/ConnexionController.php'],

];


$matchedRoute = null;

if (array_key_exists($requestUri, $routes)) {
    $matchedRoute = $routes[$requestUri];
} else if ($requestUri === 'index.php') {
    $matchedRoute = $routes[''];
}

if ($matchedRoute && $matchedRoute['type'] === 'controller') {
    if (file_exists($matchedRoute['cible'])) {
        include $matchedRoute['cible'];
    } else {
        http_response_code(500);
        echo "Erreur interne : Fichier contrôleur introuvable pour la route " . htmlspecialchars($requestUri);
        exit();
    }
    exit();
}

$viewToInclude = __DIR__ . '/../src/View/404.php';

if ($matchedRoute && $matchedRoute['type'] === 'view') {
    $viewToInclude = $matchedRoute['cible'];
} else {
    http_response_code(404);
}


include __DIR__ . '/../templates/header.php';

if (file_exists($viewToInclude)) {
    include $viewToInclude;
} else {
    http_response_code(404);
    include __DIR__ . '/../src/View/404.php';
}

// Inclure le pied de page
include __DIR__ . '/../templates/footer.php';
?>
