<?php

namespace App\Entity;

class Trajet
{
    private ?int $id = null;
    private string $villeDepart;
    private string $villeArrivee;
    private string $dateTrajet;
    private string $heureDepart;
    private ?string $description = null;
    private float $prix;
    private int $placesDisponibles;
    private bool $isElectricCar = false;
    private ?string $conducteurPseudo = null;
    private ?string $profilePicture = null;
    private ?int $rating = null;

    public function __construct(array $data = [])
    {
        if (isset($data['id'])) 
            $this->setId($data['id']);

        if (isset($data['ville_depart'])) 
            $this->setVilleDepart($data['ville_depart']);

        if (isset($data['ville_arrivee'])) 
            $this->setVilleArrivee($data['ville_arrivee']);

        if (isset($data['date_trajet']))
            $this->setDateTrajet($data['date_trajet']);

        if (isset($data['heure_depart'])) 
            $this->setHeureDepart($data['heure_depart']);

        if (isset($data['description'])) 
            $this->setDescription($data['description']);

        if (isset($data['prix'])) 
            $this->setPrix($data['prix']);

    
        if (isset($data['places_disponibles'])) 
            $this->setPlacesDisponibles($data['places_disponibles']);

        if (isset($data['electric_car'])) 
            $this->setIsElectricCar((bool)$data['electric_car']);

        if (isset($data['conducteur_pseudo'])) 
            $this->setConducteurPseudo($data['conducteur_pseudo']);

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

    public function getVilleDepart(): string
    {
        return $this->villeDepart;
    }

    public function getVilleArrivee(): string
    {
        return $this->villeArrivee;
    }

    public function getDateTrajet(): string
    {
        return $this->dateTrajet;
    }

    public function getHeureDepart(): string
    {
        return $this->heureDepart;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getPrix(): float
    {
        return $this->prix;
    }

    public function getPlacesDisponibles(): int
    {
        return $this->placesDisponibles;
    }

    public function getIsElectricCar(): bool
    {
        return $this->isElectricCar;
    }

    public function getConducteurPseudo(): ?string
    {
        return $this->conducteurPseudo;
    }

    public function getProfilePicture(): ?string
    {
        return $this->profilePicture;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }


    // --- Setters ---
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setVilleDepart(string $villeDepart): void
    {
        $this->villeDepart = $villeDepart;
    }

    public function setVilleArrivee(string $villeArrivee): void
    {
        $this->villeArrivee = $villeArrivee;
    }

    public function setDateTrajet(string $dateTrajet): void
    {
        $this->dateTrajet = $dateTrajet;
    }

    public function setHeureDepart(string $heureDepart): void
    {
        $this->heureDepart = $heureDepart;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function setPrix(float $prix): void
    {
        $this->prix = $prix;
    }

    public function setPlacesDisponibles(int $placesDisponibles): void
    {
        $this->placesDisponibles = $placesDisponibles;
    }

    public function setIsElectricCar(bool $isElectricCar): void
    {
        $this->isElectricCar = $isElectricCar;
    }

    public function setConducteurPseudo(?string $conducteurPseudo): void
    {
        $this->conducteurPseudo = $conducteurPseudo;
    }

    public function setProfilePicture(?string $profilePicture): void
    {
        $this->profilePicture = $profilePicture;
    }
    
    public function setRating(?int $rating): void
    {
        $this->rating = $rating;
    }
}
