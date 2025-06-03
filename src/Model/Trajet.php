<?php
// src/Model/Trajet.php
// Classe simple pour représenter un objet Trajet.

namespace App\Model; // <--- AJOUTER CETTE LIGNE

class Trajet
{
    public $id;
    public $ville_depart;
    public $ville_arrivee;
    public $date_trajet;
    public $heure_depart;
    public $prix;
    public $places_disponibles;
    public $conducteur_nom;

    public function __construct(array $data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }
}
