<?php

namespace App\Entity;

class Trajet
{
    public $id;
    public $ville_depart;
    public $ville_arrivee;
    public $date_trajet;
    public $heure_depart;
    public $description;
    public $prix;
    public $places_disponibles;
    public $conducteur_pseudo;

    public function __construct(array $data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }
}
