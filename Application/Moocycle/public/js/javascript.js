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
      // Vérifier si le bouton n'existe pas déjà
      if (!li.querySelector('.action-btn')) {
          // Créer un bouton
          const btn = document.createElement('button');
          btn.className = 'action-btn'; // Classe pour le style
          btn.textContent = 'Action'; // Texte du bouton
          btn.onclick = function () {
              alert('Action sur ' + li.querySelector('p').textContent);
          };

          // Ajouter le bouton à la fin du li
          li.appendChild(btn);
      }
  });

  li.addEventListener('mouseout', function (event) {
      // Vérifier si la souris quitte réellement le <li> (et non un enfant comme le bouton)
      if (!li.contains(event.relatedTarget)) {
          // Supprimer le bouton lorsque la souris quitte l'élément
          const btn = li.querySelector('.action-btn');
          if (btn) {
              li.removeChild(btn);
          }
      }
  });
});