<?php
// Ce fichier contient la classe User, qui gère la logique métier et les interactions avec la base de données pour les utilisateurs.

namespace App\Model;

use App\Database\DbConnection;
use PDOException;

class User
{
    private $pdo;

    public function __construct()
    {
        // Récupère l'instance PDO de la classe DbConnection
        $this->pdo = DbConnection::getPdo();
    }

    /**
     * Enregistre un nouvel utilisateur dans la base de données.
     *
     * @param string $pseudo Le pseudo de l'utilisateur.
     * @param string $firstName Le prénom de l'utilisateur.
     * @param string $lastName Le nom de famille de l'utilisateur.
     * @param string $email L'adresse email de l'utilisateur.
     * @param string $hashedPassword Le mot de passe haché de l'utilisateur.
     * @param int $credits Le nombre de crédits initiaux.
     * @param string $profilePicture Le chemin de la photo de profil.
     * @return bool Vrai si l'enregistrement a réussi, faux sinon.
     * @throws PDOException En cas d'erreur de base de données (ex: email/pseudo déjà utilisé).
     */
    public function registerUser(
        string $pseudo,
        string $firstName,
        string $lastName,
        string $email,
        string $hashedPassword,
        int $credits,
        string $profilePicture
    ): bool {
        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO users (pseudo, first_name, last_name, email, password, credits, profile_picture)
                VALUES (:pseudo, :first_name, :last_name, :email, :password, :credits, :profile_picture)
            ");

            $stmt->bindParam(':pseudo', $pseudo);
            $stmt->bindParam(':first_name', $firstName);
            $stmt->bindParam(':last_name', $lastName);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':credits', $credits);
            $stmt->bindParam(':profile_picture', $profilePicture);

            return $stmt->execute();

        } catch (PDOException $e) {
            // Relancer l'exception pour que le contrôleur puisse la gérer
            throw $e;
        }
    }

    /**
     * Vérifie si un email ou un pseudo existe déjà dans la base de données.
     *
     * @param string $email L'adresse email à vérifier.
     * @param string $pseudo Le pseudo à vérifier.
     * @return bool Vrai si l'email ou le pseudo existe déjà, faux sinon.
     */
    public function emailOrPseudoExists(string $email, string $pseudo): bool
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM users WHERE email = :email OR pseudo = :pseudo");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':pseudo', $pseudo);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }
}
