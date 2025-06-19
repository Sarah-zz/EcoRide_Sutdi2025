<?php

namespace App\Entity;

class User
{
    private ?int $id = null;
    private string $pseudo;
    private string $firstName;
    private string $lastName;
    private string $email;
    private ?string $phone = null;
    private string $password;
    private int $credits = 0;
    private string $profilePicture = 'default_profile.png';
    private int $rating = 0;


    public function __construct(array $data = [])
    {
        if (isset($data['id']))
            $this->setId($data['id']);

        if (isset($data['pseudo']))
            $this->setPseudo($data['pseudo']);

        if (isset($data['first_name']))
            $this->setFirstName($data['first_name']);

        if (isset($data['last_name']))
            $this->setLastName($data['last_name']);

        if (isset($data['email']))
            $this->setEmail($data['email']);

        if (isset($data['phone']))
            $this->setPhone($data['phone']);

        if (isset($data['password']))
            $this->setPassword($data['password']);

        if (isset($data['credits']))
            $this->setCredits($data['credits']);

        if (isset($data['profile_picture']))
            $this->setProfilePicture($data['profile_picture']);

        if (isset($data['rating']))
            $this->setRating($data['rating']);
    }

    // --- Getters ---
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPseudo(): string
    {
        return $this->pseudo;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getCredits(): int
    {
        return $this->credits;
    }

    public function getProfilePicture(): string
    {
        return $this->profilePicture;
    }

    public function getRating(): int
    {
        return $this->rating;
    }


    // --- Setters ---
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setPseudo(string $pseudo): void
    {
        $this->pseudo = $pseudo;
    }

    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setPhone(?string $phone): void
    {
        $this->phone = $phone;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function setCredits(int $credits): void
    {
        $this->credits = $credits;
    }

    public function setProfilePicture(string $profilePicture): void
    {
        $this->profilePicture = $profilePicture;
    }

    public function setRating(int $rating): void
    {
        $this->rating = $rating;
    }

}
