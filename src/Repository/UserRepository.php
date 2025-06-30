<?php

namespace App\Repository;

use App\Database\DbConnection;
use App\Entity\User;
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
        string $profilePicture,
        int $roleId = User::ROLE_UTILISATEUR_ID
    ): bool {
        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO users (pseudo, first_name, last_name, email, password, credits, profile_picture, role)
                VALUES (:pseudo, :first_name, :last_name, :email, :password, :credits, :profile_picture, :role)
            ");

            $stmt->bindParam(':pseudo', $pseudo);
            $stmt->bindParam(':first_name', $firstName);
            $stmt->bindParam(':last_name', $lastName);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':credits', $credits);
            $stmt->bindParam(':profile_picture', $profilePicture);
            $stmt->bindParam(':role', $roleId, PDO::PARAM_INT);

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


public function getUserById(int $id): ?User
    {
        try {
            $stmt = $this->pdo->prepare("SELECT id, pseudo, first_name, last_name, email, phone, password, credits, profile_picture, rating, role FROM users WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $userData = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($userData) {
                return new User($userData);
            }
            return null;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function getUserByEmail(string $email): ?User
    {
        try {
            $stmt = $this->pdo->prepare("SELECT id, pseudo, first_name, last_name, email, phone, password, credits, profile_picture, rating, role FROM users WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $userData = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($userData) {
                return new User($userData);
            }
            return null;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function updateUser(User $user): bool
    {
        try {
            $stmt = $this->pdo->prepare("
                UPDATE users SET
                    pseudo = :pseudo,
                    first_name = :first_name,
                    last_name = :last_name,
                    email = :email,
                    phone = :phone,
                    password = :password,
                    credits = :credits,
                    profile_picture = :profile_picture,
                    rating = :rating,
                    role = :role
                WHERE id = :id
            ");

            $id = $user->getId();

            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':pseudo', $user->getPseudo());
            $stmt->bindParam(':first_name', $user->getFirstName());
            $stmt->bindParam(':last_name', $user->getLastName());
            $stmt->bindParam(':email', $user->getEmail());
            $stmt->bindParam(':phone', $user->getPhone());
            $stmt->bindParam(':password', $user->getPassword());
            $stmt->bindParam(':credits', $user->getCredits(), PDO::PARAM_INT);
            $stmt->bindParam(':profile_picture', $user->getProfilePicture());
            $stmt->bindParam(':rating', $user->getRating(), PDO::PARAM_INT);
            $stmt->bindParam(':role', $user->getRole(), PDO::PARAM_INT);

            return $stmt->execute();

        } catch (PDOException $e) {
            throw $e;
        }
    }
}