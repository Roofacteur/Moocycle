document.addEventListener('DOMContentLoaded', function() {
    var customDialog = document.getElementById('custom-dialog');
    var dialogConfirm = document.getElementById('dialog-confirm');
    var dialogCancel = document.getElementById('dialog-cancel');
    var deleteUrl = null;
    var dialogTitle = document.getElementById('dialog-title');
    var dialogMessage = document.getElementById('dialog-message');
    const hamMenu = document.querySelector('.ham-menu');
    const offScreenMenu = document.querySelector('.off-screen-menu');

    if (hamMenu && offScreenMenu) {
        hamMenu.addEventListener('click', function() {
            // Ajouter ou supprimer la classe "active"
            hamMenu.classList.toggle('active');
            offScreenMenu.classList.toggle('active');
        });
    }
    // Fonction pour afficher le dialogue de confirmation de suppression
    function showDeleteConfirmation(li) {
        // Créer un formulaire pour la suppression
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = li.getAttribute('data-delete-href'); // URL de suppression

        // Ajouter le champ CSRF
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content'); // Récupère le token CSRF
        form.appendChild(csrfToken);

        // Ajouter le champ pour spécifier la méthode DELETE
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        form.appendChild(methodInput);

        // Ajouter le formulaire au body
        document.body.appendChild(form);

        deleteUrl = form; // Stocker le formulaire pour le soumettre après confirmation

        customDialog.style.display = 'flex'; // Afficher la boîte de dialogue

        // Récupérer le nom de la vache à partir de l'attribut 'data-cow-name'
        const cowName = li.getAttribute('data-cow-name');
        dialogMessage.textContent = `Voulez-vous vraiment supprimer ${cowName} ?`; // Afficher le nom de la vache
    }

    dialogConfirm.addEventListener('click', function() {
        if (deleteUrl) {
            deleteUrl.submit(); // Soumettre le formulaire pour supprimer la vache
        }
    });

    dialogCancel.addEventListener('click', function() {
        customDialog.style.display = 'none'; // Cache la boîte de dialogue
    });

    // Gestion des événements sur les éléments de la liste
    document.querySelectorAll('#cow-li').forEach((li) => {
        li.addEventListener('mouseover', function () {
            if (!li.querySelector('.btn-container')) {
                // Créer le conteneur pour les boutons
                const btnContainer = document.createElement('div');
                btnContainer.className = 'btn-container';

                // Récupérer l'URL de modification depuis data-edit-href
                const editLink = li.getAttribute('data-edit-href');

                // Créer le bouton Modifier
                const btnModifier = document.createElement('a');
                btnModifier.className = 'action-btn';
                btnModifier.textContent = 'Modifier';
                btnModifier.href = editLink; // Lier le lien vers la page d'édition

                // Créer le bouton Supprimer
                const btnSupprimer = document.createElement('a');
                btnSupprimer.className = 'action-btn';
                btnSupprimer.textContent = 'Supprimer';
                const deleteHref = li.getAttribute('data-delete-href'); // Récupérer l'URL de suppression depuis l'attribut data-delete-href
                btnSupprimer.setAttribute('href', "#"); // Lien vide pour empêcher l'action par défaut
                btnSupprimer.addEventListener('click', function(event) {
                    event.preventDefault(); // Empêche le lien de se déclencher immédiatement
                    showDeleteConfirmation(li); // Afficher la confirmation de suppression
                });

                // Ajouter les boutons au conteneur
                btnContainer.appendChild(btnModifier);
                btnContainer.appendChild(btnSupprimer);

                // Ajouter le conteneur au li
                li.appendChild(btnContainer);
            }
        });

        li.addEventListener('mouseout', function (event) {
            if (!li.contains(event.relatedTarget)) {
                const btnContainer = li.querySelector('.btn-container');
                if (btnContainer) {
                    li.removeChild(btnContainer);
                }
            }
        });
    });

    // Gestion du dialogue de confirmation de sortie sans sauvegarder les changements
    var cancelButton = document.querySelector('.cancel');

    // Vérification des changements dans le formulaire
    cancelButton.addEventListener('click', function(event) {
        var form = document.querySelector('form');
        var inputs = form.querySelectorAll('input, select'); // Inclure les <select> dans la détection de changement
        var isDirty = false;

        // Parcours tous les champs pour vérifier si des changements ont été effectués
        inputs.forEach(function(input) {
            if (input.tagName === 'SELECT') {
                // Vérifie si la valeur sélectionnée est différente de la valeur par défaut
                if (input.value !== input.getAttribute('data-default')) {
                    isDirty = true;
                }
            } else {
                // Vérifie si la valeur de l'input est différente de sa valeur par défaut
                if (input.value !== input.defaultValue) {
                    isDirty = true;
                }
            }
        });

        // Si des changements ont été effectués, afficher le dialogue
        if (isDirty) {
            event.preventDefault(); // Empêche la navigation
            customDialog.style.display = 'flex'; // Affiche la boîte de dialogue
            dialogTitle.textContent = "Attention"; // Change le titre de la boîte de dialogue
            dialogMessage.textContent = "Vos changements ne seront pas enregistrés. Voulez-vous vraiment quitter ?";
        } else {
            window.location.href = cancelButton.href; // Permet de quitter sans confirmation
        }
    });

    // Si l'utilisateur confirme (Oui) pour quitter sans sauvegarder
    dialogConfirm.addEventListener('click', function() {
        customDialog.style.display = 'none'; // Cache la boîte de dialogue
        window.location.href = cancelButton.getAttribute('href'); // Utilise l'URL de href du bouton Annuler
    });

    // Si l'utilisateur annule (Non) pour rester sur la page
    dialogCancel.addEventListener('click', function() {
        customDialog.style.display = 'none'; // Cache la boîte de dialogue
    });

    // Ajout des valeurs par défaut aux champs select pour la comparaison
    var selects = document.querySelectorAll('select');
    selects.forEach(function(select) {
        select.setAttribute('data-default', select.value); // Ajoute un attribut data-default pour garder la valeur initiale
    });
    
});