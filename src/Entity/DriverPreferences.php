<?php

namespace App\Entity;

class DriverPreferences
{
    private ?string $id = null;
    private int $userId;
    private ?string $musicPreference = null;
    private ?string $smokingAllowed = null;
    private ?string $petAllowed = null;
    private ?string $luggageSpace = null;
    private ?string $chatPreference = null;
    private array $customPreferences = [];

    public function __construct(array $data = [])
    {
        if (isset($data['_id'])) {
            $this->setId((string)$data['_id']);
        }
        if (isset($data['userId'])) {
            $this->setUserId((int)$data['userId']);
        }
        if (isset($data['musicPreference'])) {
            $this->setMusicPreference($data['musicPreference']);
        }
        if (isset($data['smokingAllowed'])) {
            $this->setSmokingAllowed($data['smokingAllowed']);
        }
        if (isset($data['petAllowed'])) {
            $this->setPetAllowed($data['petAllowed']);
        }
        if (isset($data['luggageSpace'])) {
            $this->setLuggageSpace($data['luggageSpace']);
        }
        if (isset($data['chatPreference'])) {
            $this->setChatPreference($data['chatPreference']);
        }
        if (isset($data['customPreferences']) && is_array($data['customPreferences'])) {
            $this->setCustomPreferences($data['customPreferences']);
        }
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getMusicPreference(): ?string
    {
        return $this->musicPreference;
    }

    public function getSmokingAllowed(): ?string
    {
        return $this->smokingAllowed;
    }

    public function getPetAllowed(): ?string
    {
        return $this->petAllowed;
    }

    public function getLuggageSpace(): ?string
    {
        return $this->luggageSpace;
    }

    public function getChatPreference(): ?string
    {
        return $this->chatPreference;
    }

    public function getCustomPreferences(): array
    {
        return $this->customPreferences;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    public function setMusicPreference(?string $musicPreference): void
    {
        $this->musicPreference = $musicPreference;
    }

    public function setSmokingAllowed(?string $smokingAllowed): void
    {
        $this->smokingAllowed = $smokingAllowed;
    }

    public function setPetAllowed(?string $petAllowed): void
    {
        $this->petAllowed = $petAllowed;
    }

    public function setLuggageSpace(?string $luggageSpace): void
    {
        $this->luggageSpace = $luggageSpace;
    }

    public function setChatPreference(?string $chatPreference): void
    {
        $this->chatPreference = $chatPreference;
    }

    public function setCustomPreferences(array $customPreferences): void
    {
        $this->customPreferences = $customPreferences;
    }

    public function toArray(): array
    {
        $data = [
            'userId' => $this->userId,
            'musicPreference' => $this->musicPreference,
            'smokingAllowed' => $this->smokingAllowed,
            'petAllowed' => $this->petAllowed,
            'luggageSpace' => $this->luggageSpace,
            'chatPreference' => $this->chatPreference,
            'customPreferences' => $this->customPreferences,
        ];
        if ($this->id !== null) {
            $data['_id'] = new \MongoDB\BSON\ObjectId($this->id);
        }
        return $data;
    }
}
