<div class="container">
    <?php
    if (!isset($user) || !($user instanceof \App\Entity\User) ||
        !isset($preferences) || !($preferences instanceof \App\Entity\DriverPreferences) ||
        !isset($form) || !($form instanceof \App\Form\DriverPreferencesForm)) {
        echo '<div class="alert alert-danger" role="alert">Erreur : Les informations nécessaires ne sont pas disponibles.</div>';
        return;
    }
    ?>

    <h1 class="text-center mb-4">Préférences de Conduite de <?php echo htmlspecialchars($user->getPseudo()); ?></h1>

    <?php if (isset($messageType) && $messageType && !empty($messageContent)): ?>
        <div class="alert alert-<?php echo htmlspecialchars($messageType); ?> shadow-sm" role="alert">
            <?php if (isset($messageTitle) && !empty($messageTitle)): ?>
                <h4 class="alert-heading"><?php echo htmlspecialchars($messageTitle); ?></h4>
            <?php endif; ?>
            <?php foreach ($messageContent as $msg): ?>
                <p class="mb-0"><?php echo htmlspecialchars($msg); ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <p class="text-center text-muted mb-5">Définissez vos préférences pour les covoiturages.</p>

    <form action="<?php echo htmlspecialchars($base_url); ?>/backend/driver/preferences" method="POST" class="needs-validation" novalidate>
        <?php
        echo $form->renderMusicPreferenceSelect();
        echo $form->renderSmokingAllowedSelect();
        echo $form->renderPetAllowedSelect();
        echo $form->renderLuggageSpaceSelect();
        echo $form->renderChatPreferenceSelect();
        ?>

        <div class="mb-4">
            <label for="newCustomPreference" class="form-label">Ajouter une préférence personnalisée :</label>
            <div class="input-group">
                <input type="text" class="form-control" id="newCustomPreference" placeholder="Ex: 'Pas de musique forte', 'Arrêts fréquents'">
                <button class="btn btn-outline-primary" type="button" id="addCustomPreference">Ajouter</button>
            </div>
            <ul id="customPreferencesList" class="list-group mt-2">
                <?php
                $currentCustomPreferences = $form->get('customPreferences', []);
                foreach ($currentCustomPreferences as $pref):
                ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><?php echo htmlspecialchars($pref); ?></span>
                        <button type="button" class="btn btn-sm btn-outline-danger remove-custom-preference">Supprimer</button>
                        <input type="hidden" name="customPreferences[]" value="<?php echo htmlspecialchars($pref); ?>">
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <button type="submit" class="btn btn-primary shadow-sm mt-3">Enregistrer les préférences</button>
    </form>

    <hr class="my-5">

    <div class="text-center">
        <a href="<?php echo htmlspecialchars($base_url); ?>/userdashboard" class="btn btn-secondary">Retour au tableau de bord</a>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const addBtn = document.getElementById('addCustomPreference');
        const newPrefInput = document.getElementById('newCustomPreference');
        const prefList = document.getElementById('customPreferencesList');

        function addPreferenceItem(preferenceText) {
            const trimmedText = preferenceText.trim();
            if (trimmedText === '') {
                return;
            }

            const li = document.createElement('li');
            li.className = 'list-group-item d-flex justify-content-between align-items-center';
            li.innerHTML = `
                <span>${escapeHtml(trimmedText)}</span>
                <button type="button" class="btn btn-sm btn-outline-danger remove-custom-preference">Supprimer</button>
            `;

            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'customPreferences[]';
            hiddenInput.value = trimmedText;
            li.appendChild(hiddenInput);

            prefList.appendChild(li);
            newPrefInput.value = '';

            li.querySelector('.remove-custom-preference').addEventListener('click', function() {
                li.remove();
            });
        }

        addBtn.addEventListener('click', function() {
            addPreferenceItem(newPrefInput.value);
        });

        newPrefInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                addPreferenceItem(newPrefInput.value);
            }
        });

        document.querySelectorAll('.remove-custom-preference').forEach(button => {
            button.addEventListener('click', function() {
                this.closest('li').remove();
            });
        });

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.appendChild(document.createTextNode(text));
            return div.innerHTML;
        }
    });
</script>
