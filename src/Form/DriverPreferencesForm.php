<?php

namespace App\Form;

class DriverPreferencesForm
{
    private array $data;
    private array $errors = [];
    private bool $isSubmitted = false;

    public function __construct(array $formData)
    {
        $this->data = $formData;
        $this->isSubmitted = $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    public function isSubmitted(): bool
    {
        return $this->isSubmitted;
    }

    public function isValid(): bool
    {
        $this->errors = [];

        // Validation des préférences personnalisées
        if (isset($this->data['customPreferences']) && is_array($this->data['customPreferences'])) {
            foreach ($this->data['customPreferences'] as $index => $preference) {
                $trimmedPreference = trim($preference);
                if (!empty($preference) && empty($trimmedPreference)) {
                    $this->errors[] = "La préférence personnalisée #" . ($index + 1) . " ne peut pas être vide ou contenir uniquement des espaces.";
                }
            }
        }

        return empty($this->errors);
    }

    public function getData(): array
    {
        $cleanedCustomPreferences = [];
        if (isset($this->data['customPreferences']) && is_array($this->data['customPreferences'])) {
            foreach ($this->data['customPreferences'] as $preference) {
                $trimmed = trim($preference);
                if (!empty($trimmed)) {
                    $cleanedCustomPreferences[] = $trimmed;
                }
            }
        }

        return [
            'musicPreference' => $this->data['musicPreference'] ?? null,
            'smokingAllowed' => $this->data['smokingAllowed'] ?? null,
            'petAllowed' => $this->data['petAllowed'] ?? null,
            'luggageSpace' => $this->data['luggageSpace'] ?? null,
            'chatPreference' => $this->data['chatPreference'] ?? null,
            'customPreferences' => $cleanedCustomPreferences,
        ];
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function get(string $fieldName, $defaultValue = null)
    {
        return $this->data[$fieldName] ?? $defaultValue;
    }

    private function renderSelectField(string $name, string $label, array $options): string
    {
        $selectedValue = $this->get($name);
        $html = '<div class="mb-4">';
        $html .= '<label for="' . htmlspecialchars($name) . '" class="form-label">' . htmlspecialchars($label) . ' :</label>';
        $html .= '<select class="form-select" id="' . htmlspecialchars($name) . '" name="' . htmlspecialchars($name) . '">';
        $html .= '<option value="">Sélectionnez une option</option>';
        foreach ($options as $value => $optionLabel) {
            $selected = ($selectedValue === $value) ? 'selected' : '';
            $html .= '<option value="' . htmlspecialchars($value) . '" ' . $selected . '>' . htmlspecialchars($optionLabel) . '</option>';
        }
        $html .= '</select>';
        $html .= '</div>';
        return $html;
    }

    public function renderMusicPreferenceSelect(): string
    {
        $options = [
            'silence' => 'Je ne mets pas/peu de musique',
            'radio' => 'Je mets souvent la radio',
            'passenger_choice' => 'J\'écoute de tout et j\'adore découvrir de nouveaux artistes !',
        ];
        return $this->renderSelectField('musicPreference', 'Préférence musicale', $options);
    }

    public function renderSmokingAllowedSelect(): string
    {
        $options = [
            'no' => 'Pas de cigarette svp',
            'yes' => 'Pauses cigarette hors de la voiture',
            'yes_in_car' => 'Oui',
        ];
        return $this->renderSelectField('smokingAllowed', 'Fumeur en voiture', $options);
    }

    public function renderPetAllowedSelect(): string
    {
        $options = [
            'no' => 'Je ne préfère pas',
            'small_caged' => 'Oui (petits, en cage)',
            'any' => 'Oui (tout type)',
        ];
        return $this->renderSelectField('petAllowed', 'Animaux de compagnie autorisés', $options);
    }

    public function renderLuggageSpaceSelect(): string
    {
        $options = [
            'small' => 'Petit (sac à dos)',
            'medium' => 'Moyen (valise cabine)',
            'large' => 'Grand (grosse valise)',
        ];
        return $this->renderSelectField('luggageSpace', 'Espace bagages', $options);
    }

    public function renderChatPreferenceSelect(): string
    {
        $options = [
            'talkative' => 'Bavard',
            'quiet' => 'Plutôt calme',
            'depends' => 'J\'aime bien papoter quand je me sens à l\'aise'
        ];
        return $this->renderSelectField('chatPreference', 'Discussions', $options);
    }
}
