<?php

namespace App\Repository;

use App\Database\DbConnection;
use PDO;
use PDOException;

class TrajetRepository
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = DbConnection::getPdo();
    }

    public function searchTrajets(
        string $villeDepart,
        string $villeArrivee,
        string $dateTrajet,
    ): array {
        $results = [];

        try {
            $sql = "SELECT
                        t.id,
                        t.ville_depart,
                        t.ville_arrivee,
                        t.date_trajet,
                        t.heure_depart,
                        t.heure_arrivee,
                        t.prix,
                        t.places_disponibles,
                        t.description,
                        t.is_electric_car,
                        u.pseudo AS conducteur_pseudo,
                        u.profile_picture,
                        u.rating
                    FROM trajets t
                    JOIN users u ON t.conducteur_id = u.id
                    WHERE t.places_disponibles >= 1";

            $params = [];

            if (!empty($villeDepart)) {
                $sql .= " AND t.ville_depart LIKE ?";
                $params[] = '%' . $villeDepart . '%';
            }
            if (!empty($villeArrivee)) {
                $sql .= " AND t.ville_arrivee LIKE ?";
                $params[] = '%' . $villeArrivee . '%';
            }
            if (!empty($dateTrajet)) {
                $sql .= " AND t.date_trajet = ?";
                $params[] = $dateTrajet;
            }

            $sql .= " ORDER BY t.date_trajet, t.heure_depart";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw $e;
        }

        return $results;
    }
}
