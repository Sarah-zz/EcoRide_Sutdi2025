<?php
// public/index.php - Le Front Controller / Routeur

session_start(); // Démarre la session pour toute l'application

// Inclure l'autoloader de Composer au tout début
require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// --- Début de la logique du Routeur ---

// 1. Obtenir l'URI de la requête
$requestUri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

// Si votre projet est dans un sous-dossier (ex: http://localhost/EcoRide/),
// la variable $requestUri contiendra 'EcoRide/covoiturage'.
// Nous devons retirer ce préfixe pour que le routeur fonctionne.
// Adaptez 'EcoRide' au nom exact de votre dossier de projet.
// Si votre projet est directement à la racine (ex: http://localhost/), vous pouvez commenter cette section.
$basePath = 'EcoRide'; // <--- IMPORTANT: Adaptez ce chemin si votre dossier de projet est différent
if (strpos($requestUri, $basePath) === 0) {
    $requestUri = substr($requestUri, strlen($basePath));
    $requestUri = trim($requestUri, '/'); // Retire le slash de début s'il y en a un après suppression
}


// 2. Définir les routes
// Chaque clé est le "chemin" de l'URL (après le basePath), et la valeur est :
// - Pour les Vues : le chemin complet du fichier PHP de la Vue.
// - Pour les Contrôleurs : le nom complet de la classe du Contrôleur (avec son namespace).
$routes = [
    '' => __DIR__ . '/../src/View/welcome.php', // Page d'accueil (pour '/')
    'covoiturage' => __DIR__ . '/../src/View/covoiturage.php', // Page du formulaire de recherche
    'resultats' => __DIR__ . '/../src/View/resultatrecherche.php', // Page d'affichage des résultats
    'signin' => __DIR__ . '/../src/View/signin.php', // Page d'inscription
    'login' => __DIR__ . '/../src/View/login.php', // Page de connexion
    'contact' => __DIR__ . '/../src/View/contact.php', // Page de contact
    'admin' => __DIR__ . '/../src/View/adminpage.php', // Page administrateur
    // Routes pour les traitements (Contrôleurs)
    'backend/recherche' => 'App\\Controller\\RechercheController', // Nom complet de la classe du contrôleur
    'backend/register' => 'App\\Controller\\RegisterController',
    'backend/contact_process' => 'App\\Controller\\ContactController',
    // Ajoutez d'autres routes ici
];

// 3. Dispatcher la requête
$requestedResource = null; // Peut être un chemin de fichier (pour une Vue) ou un nom de classe (pour un Contrôleur)

if (array_key_exists($requestUri, $routes)) {
    $requestedResource = $routes[$requestUri];
} else if ($requestUri === 'index.php') { // Gérer le cas où l'utilisateur accède directement à index.php
    $requestedResource = __DIR__ . '/../src/View/welcome.php';
}

// Inclure le header une seule fois pour toute l'application
include __DIR__ . '/../templates/header.php';

// Traiter la ressource demandée
if ($requestedResource) {
    // Vérifie si la ressource est un nom de classe (commence par 'App\')
    if (strpos($requestedResource, 'App\\') === 0) {
        // C'est un nom de classe de contrôleur
        if (class_exists($requestedResource)) {
            // L'autoloader de Composer se chargera d'inclure le fichier du contrôleur.
            // On peut instancier le contrôleur si on veut appeler une méthode dessus,
            // ou juste inclure le fichier si le contrôleur est un script simple.
            // Pour la structure actuelle (scripts simples), on doit inclure le fichier.
            include str_replace('\\', '/', __DIR__ . '/../' . $requestedResource) . '.php';
        } else {
            // Si la classe du contrôleur n'existe pas (erreur de développement)
            http_response_code(500);
            echo "Erreur interne : Contrôleur introuvable pour la route " . htmlspecialchars($requestUri);
        }
    } else {
        // C'est un chemin de fichier de vue
        if (file_exists($requestedResource)) {
            include $requestedResource;
        } else {
            // Si le fichier de la vue n'existe pas (erreur de développement ou route mal configurée)
            http_response_code(404);
            include __DIR__ . '/../src/View/404.php';
        }
    }
} else {
    // Si aucune route n'a été trouvée pour l'URI demandée
    http_response_code(404);
    include __DIR__ . '/../src/View/404.php'; // Assurez-vous d'avoir une page 404.php
}

// Inclure le footer une seule fois pour toute l'application
include __DIR__ . '/../templates/footer.php';
?>
