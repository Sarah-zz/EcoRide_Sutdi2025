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
        int $roleId = User::ROLE_UTILISATEUR_ID,
        bool $isDriver = false,
        bool $isPassenger = true
    ): bool {
        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO users (pseudo, first_name, last_name, email, password, credits, profile_picture, role, is_driver, is_passenger)
                VALUES (:pseudo, :first_name, :last_name, :email, :password, :credits, :profile_picture, :role, :isDriver, :isPassenger)
            ");

            $stmt->bindParam(':pseudo', $pseudo);
            $stmt->bindParam(':first_name', $firstName);
            $stmt->bindParam(':last_name', $lastName);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':credits', $credits);
            $stmt->bindParam(':profile_picture', $profilePicture);
            $stmt->bindParam(':role', $roleId, PDO::PARAM_INT);
            $stmt->bindParam(':isDriver', $isDriver, PDO::PARAM_BOOL);
            $stmt->bindParam(':isPassenger', $isPassenger, PDO::PARAM_BOOL);

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
            $stmt = $this->pdo->prepare(
                "SELECT id, pseudo, first_name, last_name, email, phone, password, credits, profile_picture, rating, role, is_driver, is_passenger
                FROM users WHERE id = :id");
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
            $stmt = $this->pdo->prepare(
                "SELECT id, pseudo, first_name, last_name, email, phone, password, credits, profile_picture, rating, role, is_driver, is_passenger
                FROM users WHERE email = :email");
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
                    role = :role,
                    is_driver = :isDriver,
                    is_passenger = :isPassenger
                WHERE id = :id
            ");

            $id = $user->getId();
            $pseudo = $user->getPseudo();
            $firstName = $user->getFirstName();
            $lastName = $user->getLastName();
            $email = $user->getEmail();
            $phone = $user->getPhone();
            $password = $user->getPassword();
            $credits = $user->getCredits();
            $profilePicture = $user->getProfilePicture();
            $rating = $user->getRating();
            $role = $user->getRole();
            $isDriver = $user->getIsDriver();
            $isPassenger = $user->getIsPassenger();

            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':pseudo', $pseudo);
            $stmt->bindParam(':first_name', $firstName);
            $stmt->bindParam(':last_name', $lastName);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':credits', $credits, PDO::PARAM_INT);
            $stmt->bindParam(':profile_picture', $profilePicture);
            $stmt->bindParam(':rating', $rating, PDO::PARAM_INT);
            $stmt->bindParam(':role', $role, PDO::PARAM_INT);
            $stmt->bindParam(':isDriver', $isDriver, PDO::PARAM_BOOL);
            $stmt->bindParam(':isPassenger', $isPassenger, PDO::PARAM_BOOL);

            return $stmt->execute();

        } catch (PDOException $e) {
            throw $e;
        }
    }
}
