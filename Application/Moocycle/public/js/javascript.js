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