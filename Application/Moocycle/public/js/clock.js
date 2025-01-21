'use strict';
function startDate() {
    const today = new Date();
    let year = today.getFullYear();
    let month = today.getMonth() + 1; // Les mois commencent à 0
    let day = today.getDate();
    month = checkTime(month);
    day = checkTime(day);
    document.getElementById('clock').innerHTML = day + "."+ month+ "." + year;
    document.getElementById('currentyear').innerHTML = year;
    setTimeout(startDate, 1000); // Actualisation toutes les secondes
}
function checkTime(i) {
    if (i < 10) {i = "0" + i};  // Ajouter un zéro devant les chiffres < 10
    return i;
}
startDate();