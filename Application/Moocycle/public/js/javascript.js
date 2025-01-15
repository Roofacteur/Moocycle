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
            
            // Créer le bouton Modifier
            const btnModifier = document.createElement('a');  // Utilisation de <a> pour un lien
            btnModifier.className = 'action-btn';
            btnModifier.textContent = 'Modifier';
            btnModifier.href =`{{ route('editcows') }}`;

            // Ajouter le lien de la route Laravel dans href
            const numTblVache = li.querySelector('p').textContent;  // Assure-toi de récupérer le bon ID (num_tblVache)
            const editLink = li.dataset.href;  // Récupérer l'URL depuis data-href
            btnModifier.href = editLink; // Lier le lien vers la page d'édition

            // Créer le bouton Supprimer
            const btnSupprimer = document.createElement('a');  // Même pour le bouton Supprimer
            btnSupprimer.className = 'action-btn';
            btnSupprimer.textContent = 'Supprimer';
            btnSupprimer.href = ``; // Utilisation de num_tblVache pour la suppression

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
