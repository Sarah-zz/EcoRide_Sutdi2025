<?php

namespace App\Repository;

use App\Database\MongoDbConnection;
use App\Entity\DriverPreferences;
use MongoDB\Collection;
use MongoDB\BSON\ObjectId;
use MongoDB\Driver\Exception\Exception as MongoDBDriverException;

class DriverPreferencesRepository
{
    private Collection $collection;

    public function __construct()
    {
        $database = MongoDbConnection::getDatabase();
        $this->collection = $database->selectCollection('driver_preferences');
    }

    public function findByUserId(int $userId): ?DriverPreferences
    {
        try {
            $document = $this->collection->findOne(['userId' => $userId]);
            if ($document) {
                return new DriverPreferences((array)$document);
            }
            return null;
        } catch (MongoDBDriverException $e) {
            error_log("MongoDB: Erreur lors de la recherche des préférences conducteur pour userId $userId: " . $e->getMessage());
            throw $e;
        }
    }

    public function save(DriverPreferences $preferences): bool
    {
        try {
            $data = $preferences->toArray();
            $userId = $preferences->getUserId();

            $result = $this->collection->updateOne(
                ['userId' => $userId],
                ['$set' => $data],
                ['upsert' => true]
            );
            return $result->getModifiedCount() > 0 || $result->getUpsertedCount() > 0;
        } catch (MongoDBDriverException $e) {
            error_log("MongoDB: Erreur lors de la sauvegarde des préférences conducteur pour userId " . $preferences->getUserId() . ": " . $e->getMessage());
            throw $e;
        }
    }

    public function deleteByUserId(int $userId): bool
    {
        try {
            $result = $this->collection->deleteOne(['userId' => $userId]);
            return $result->getDeletedCount() > 0;
        } catch (MongoDBDriverException $e) {
            error_log("MongoDB: Erreur lors de la suppression des préférences conducteur pour userId $userId: " . $e->getMessage());
            throw $e;
        }
    }
}
