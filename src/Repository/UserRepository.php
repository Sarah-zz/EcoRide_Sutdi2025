<?php

namespace App\Repository;

use App\Database\DbConnection;
use PDO;
use PDOException;

class UserRepository
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = DbConnection::getPdo();
    }

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
            throw $e;
        }
    }

    public function emailOrPseudoExists(string $email, string $pseudo): bool
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM users WHERE email = :email OR pseudo = :pseudo");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':pseudo', $pseudo);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }
}
