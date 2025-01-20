'use strict';
const hamMenu = document.querySelector(".ham-menu");
const offScreenMenu = document.querySelector(".off-screen-menu");

function startDate() {
    const today = new Date();
    let year = today.getFullYear();
    let month = today.getMonth() + 1; // Les mois commencent à 0
    let day = today.getDate();
    month = checkTime(month);
    day = checkTime(day);
    document.getElementById('clock').innerHTML = year + "/" + month + "/" + day;
    document.getElementById('currentyear').innerHTML = year
    setTimeout(startDate, 1000); // Actualisation toutes les secondes
}
function checkTime(i) {
    if (i < 10) {i = "0" + i};  // Ajouter un zéro devant les chiffres < 10
    return i;
}
startDate();
hamMenu.addEventListener("click", () => {
  hamMenu.classList.toggle("active");
  offScreenMenu.classList.toggle("active");
});

document.querySelectorAll('#cow-li').forEach((li) => {
    li.addEventListener('mouseover', function () {
        if (!li.querySelector('.btn-container')) {
            // Créer le conteneur pour les boutons
            const btnContainer = document.createElement('div');
            btnContainer.className = 'btn-container';

            // Récupérer l'URL de modification depuis data-edit-href
            const editLink = li.getAttribute('data-edit-href');

            // Créer le bouton Modifier
            const btnModifier = document.createElement('a'); // Utilisation de <a> pour un lien
            btnModifier.className = 'action-btn';
            btnModifier.textContent = 'Modifier';
            btnModifier.href = editLink; // Lier le lien vers la page d'édition

            // Créer le bouton Supprimer
            const btnSupprimer = document.createElement('a'); // Même pour le bouton Supprimer
            btnSupprimer.className = 'action-btn';
            btnSupprimer.textContent = 'Supprimer';
            btnSupprimer.href = "#"; // Lien de suppression (à définir si besoin)

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
document.addEventListener('DOMContentLoaded', function() {
    var cancelButton = document.querySelector('.cancel');
    var customDialog = document.getElementById('custom-dialog');
    var dialogTitle = document.getElementById('dialog-title');
    var dialogMessage = document.getElementById('dialog-message');
    var dialogConfirm = document.getElementById('dialog-confirm');
    var dialogCancel = document.getElementById('dialog-cancel');

    cancelButton.addEventListener('click', function(event) {
        var form = document.querySelector('form');
        var inputs = form.querySelectorAll('input');
        var isDirty = false;

        inputs.forEach(function(input) {
            if (input.value !== input.defaultValue) {
                isDirty = true;
            }
        });

        if (isDirty) {
            event.preventDefault(); // Empêche la navigation
            customDialog.style.display = 'flex'; // Affiche la boîte de dialogue personnalisée
            dialogTitle.textContent = "Attention"; // Change le titre de la boîte de dialogue
            dialogMessage.textContent = "Vos changements ne seront pas enregistrés. Voulez-vous vraiment quitter ?";
        } else {
            window.location.href = cancelButton.href; // Permet de quitter sans confirmation
        }
    });

    // Si l'utilisateur confirme (Oui)
    dialogConfirm.addEventListener('click', function() {
        customDialog.style.display = 'none'; // Cache la boîte de dialogue
        window.location.href = cancelButton.href; // Permet de quitter
    });

    // Si l'utilisateur annule (Non)
    dialogCancel.addEventListener('click', function() {
        customDialog.style.display = 'none'; // Cache la boîte de dialogue
    });
});
