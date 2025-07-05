<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
//ini_set('log_errors', 1);
//ini_set('error_log', __DIR__ . '/../php_errors.log');

ob_start();
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

//autoloader de Composer au tout début
require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

use App\Database\MongoDbConnection;

$mongoHost = $_ENV['MONGO_HOST'] ?? 'mongodb';
$mongoPort = $_ENV['MONGO_PORT'] ?? '27017';
$mongoDbName = $_ENV['MONGO_APP_DB'] ?? 'ecoride_db';

$mongoUri = "mongodb://";
if (!empty($_ENV['MONGO_USERNAME']) && !empty($_ENV['MONGO_PASSWORD'])) {
    $mongoUri .= urlencode($_ENV['MONGO_USERNAME']) . ":" . urlencode($_ENV['MONGO_PASSWORD']) . "@";
}
$mongoUri .= "$mongoHost:$mongoPort";

try {
    MongoDbConnection::initialize($mongoUri, $mongoDbName);
    error_log("index.php: MongoDB Connection initialized successfully.");
} catch (Exception $e) {
    error_log("index.php: Erreur critique lors de l'initialisation de MongoDB: " . $e->getMessage());
    http_response_code(500);
    echo "Une erreur interne est survenue. Veuillez réessayer plus tard.";
    exit();
}

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
    'admindashboard' => ['type' => 'view', 'cible' => __DIR__ . '/../src/View/adminpage.php'],
    'employedashboard' => ['type' => 'view', 'cible' => __DIR__ . '/../src/View/employepage.php'],
    'contact_reponse' => ['type' => 'view', 'cible' => __DIR__ . '/../src/View/contactanswer.php'],
    'inscription_reussie' => ['type' => 'view', 'cible' => __DIR__ . '/../src/View/signinsuccess.php'],
    'userdashboard' => ['type' => 'controller', 'cible' => __DIR__ . '/../src/Controller/UserDashboardController.php', 'render_view' => __DIR__ . '/../src/View/userdashboard.php'],
    // Routes des contrôleurs (pour les traitements backend)
    'backend/recherche' => ['type' => 'controller', 'cible' => __DIR__ . '/../src/Controller/RechercheController.php'],
    'backend/register' => ['type' => 'controller', 'cible' => __DIR__ . '/../src/Controller/RegisterController.php'],
    'backend/contact_process' => ['type' => 'controller', 'cible' => __DIR__ . '/../src/Controller/ContactController.php'],
    'backend/login' => ['type' => 'controller', 'cible' => __DIR__ . '/../src/Controller/ConnexionController.php'],
    'backend/driver/preferences' => ['type' => 'controller', 'cible' => __DIR__ . '/../src/Controller/DriverController.php'],
    'logout' => ['type' => 'controller', 'cible' => __DIR__ . '/../src/Controller/ConnexionController.php'],
    //'dashboard' => ['type' => 'controller', 'cible' => __DIR__ . '/../src/Controller/UserDashboardController.php']

    'backend/driver/preferences' => ['type' => 'controller', 'cible' => __DIR__ . '/../src/Controller/DriverController.php', 'render_view' => __DIR__ . '/../src/View/driverpreferences.php'],


];


$matchedRoute = null;
$viewToInclude = __DIR__ . '/../src/View/404.php';

$data = [];

if (array_key_exists($requestUri, $routes)) {
    $matchedRoute = $routes[$requestUri];
} else if ($requestUri === 'index.php') {
    $matchedRoute = $routes[''];
}

if ($matchedRoute) {
    if ($matchedRoute['type'] === 'controller') {
        if (file_exists($matchedRoute['cible'])) {
            include $matchedRoute['cible'];

            if (isset($matchedRoute['render_view'])) {
                if (!isset($data) || !is_array($data)) {
                    $data = [];
                    error_log("Routeur: \$data n'a pas été défini ou n'est pas un tableau par le contrôleur " . $matchedRoute['cible']);
                }
                extract($data);
                $viewToInclude = $matchedRoute['render_view'];
            } else {
            }
        } else {
            http_response_code(500);
            echo "Erreur interne : Fichier contrôleur introuvable pour la route " . htmlspecialchars($requestUri);
            exit();
        }
    } elseif ($matchedRoute['type'] === 'view') {
        $viewToInclude = $matchedRoute['cible'];
    }
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

include __DIR__ . '/../templates/footer.php';

ob_end_flush();
?>