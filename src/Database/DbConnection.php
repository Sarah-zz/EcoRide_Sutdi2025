<?php
// src/Database/DbConnection.php
// Classe Singleton pour gérer la connexion à la base de données en utilisant des variables d'environnement.

namespace App\Database;

use PDO;
use PDOException;

class DbConnection
{
    private static $pdo = null;
    private static $instance = null;

    public function __construct()
    {
        // Le constructeur est privé pour empêcher l'instanciation directe.
        // La connexion PDO est initialisée ici.
        try {
            // Récupère les variables d'environnement depuis $_ENV
            // Assurez-vous que le fichier .env a été chargé auparavant (par public/index.php)
            $dsn = $_ENV['DB_DSN'];
            $user = $_ENV['DB_USER'];
            $password = $_ENV['DB_PASSWORD'];

            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Lance des exceptions en cas d'erreur
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Récupère les résultats sous forme de tableau associatif
                PDO::ATTR_EMULATE_PREPARES   => false,                  // Désactive l'émulation des requêtes préparées pour une meilleure sécurité et performance
            ];

            $this->pdo = new PDO($dsn, $user, $password, $options);
        } catch (PDOException $e) {
            // Erreur spécifique de la connexion PDO
            die('Erreur de connexion à la base de données : ' . $e->getMessage());
        } catch (\Exception $e) {
            // Captures d'autres exceptions, par exemple si les variables $_ENV ne sont pas définies.
            die('Erreur de configuration de la base de données : ' . $e->getMessage() . ' (Vérifiez votre fichier .env et son chargement dans public/index.php).');
        }
    }

    public static function getInstance(): DbConnection
    {
        return self::createOrReturnInstance();
    }

    public static function getPdo(): PDO
    {
        return self::createOrReturnInstance()->pdo;
    }

    private static function createOrReturnInstance(): DbConnection
    {
        if (!self::$instance) {
            self::$instance = new DbConnection();
        }

        return self::$instance;
    }
}
