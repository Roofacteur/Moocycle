document.addEventListener('DOMContentLoaded', function() {
    var customDialog = document.getElementById('custom-dialog');
    var dialogConfirm = document.getElementById('dialog-confirm');
    var dialogCancel = document.getElementById('dialog-cancel');
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
    function confirmDelete(button) {
        const cowName = button.getAttribute('data-cow-name');
        const deleteHref = button.getAttribute('data-delete-href');

        // Créer un formulaire de suppression
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = deleteHref;

        // Champ CSRF
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        form.appendChild(csrfToken);

        // Champ méthode DELETE
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        form.appendChild(methodInput);

        document.body.appendChild(form); // Ajouter temporairement au DOM
        deleteForm = form;

        // Afficher la boîte de dialogue de confirmation
        customDialog.style.display = 'flex';
        const dialogMessage = document.getElementById('dialog-message');
        dialogMessage.textContent = `Voulez-vous vraiment supprimer ${cowName} ?`;
    }

    dialogConfirm.addEventListener('click', function() {
        if (deleteUrl) {
            deleteUrl.submit(); // Soumettre le formulaire pour supprimer la vache
        }
    });

    dialogCancel.addEventListener('click', function() {
        customDialog.style.display = 'none'; // Cache la boîte de dialogue
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