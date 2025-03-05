document.addEventListener('DOMContentLoaded', function () {
    const elements = {
        hamMenu: document.querySelector('.ham-menu'),
        offScreenMenu: document.querySelector('.off-screen-menu'),
        overlay: document.querySelector('.menu-overlay'),
        confirmButton: document.getElementById('dialog-confirm'),
        cancelButton: document.getElementById('dialog-cancel'),
        dialogTitle: document.getElementById('dialog-title'),
        customDialog: document.getElementById('custom-dialog'),
        dialogMessage: document.getElementById('dialog-message'),
        chaleurButton: document.getElementById('btn-chaleur')
    };

    let selectedCowId;
    let deleteUrl = '';

    function toggleMenu() {
        elements.hamMenu.classList.toggle('active');
        elements.offScreenMenu.classList.toggle('active');
        elements.overlay.classList.toggle('active');
    }

    function closeMenu() {
        elements.hamMenu.classList.remove('active');
        elements.offScreenMenu.classList.remove('active');
        elements.overlay.classList.remove('active');
    }

    function showDialog(message, action = '') {
        elements.dialogMessage.textContent = message;
        elements.confirmButton.dataset.action = action;
        elements.customDialog.style.display = 'flex';
    }

    function sendPostRequest(url) {
        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({})
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) location.reload();
            else alert("Une erreur est survenue.");
        })
        .catch(error => {
            console.error('Erreur de la requête:', error);
            alert("Une erreur est survenue.");
        });
    }

    function deleteCow() {
        if (!deleteUrl) return;
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = deleteUrl;
        form.innerHTML = `
            <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').content}">
            <input type="hidden" name="_method" value="DELETE">
        `;
        document.body.appendChild(form);
        form.submit();
    }

    // Gestion du menu
    if (elements.hamMenu && elements.offScreenMenu && elements.overlay) {
        elements.hamMenu.addEventListener('click', toggleMenu);
        elements.overlay.addEventListener('click', closeMenu);
    }

    // Gestion des boutons d'action
    document.body.addEventListener('click', function (event) {
        const target = event.target;
        if (target.matches('.lactation-btn')) {
            selectedCowId = target.dataset.cowId;
            showDialog(`Voulez-vous ajouter une lactation à ${target.closest('li').dataset.cowName} ? Nombre de lactations actuel : ${target.dataset.cowLactation}`, 'increment-lactation');
        }
        if (target.matches('.chaleur-btn')) {
            selectedCowId = target.dataset.cowId;
            showDialog(`${target.closest('li').dataset.cowName} est en chaleur ?`, 'add-latest-date');
        }
        if (target.matches('.delete-btn')) {
            event.preventDefault();
            deleteUrl = target.dataset.deleteHref;
            if (!deleteUrl) return console.error("URL de suppression manquante.");
            showDialog(`Voulez-vous vraiment supprimer ${target.dataset.cowName} ?`);
        }
    });

    elements.chaleurButton?.addEventListener('click', function () {
        showDialog("Confirmer l'ajout de la dernière date de chaleur", 'add-latest-date');
    });

    elements.confirmButton?.addEventListener('click', function () {
        if (selectedCowId && elements.confirmButton.dataset.action === 'add-latest-date') {

            console.log(`Envoi d'une requête POST à /health/${selectedCowId}/add-latest-date`);

            sendPostRequest(`/health/${selectedCowId}/add-latest-date`);
            
        } else if (selectedCowId && elements.confirmButton.dataset.action === 'increment-lactation') {
            sendPostRequest(`/health/${selectedCowId}/increment-lactation`);
        } else {
            deleteCow();
        }
        elements.customDialog.style.display = 'none';
    });

    elements.cancelButton?.addEventListener('click', () => elements.customDialog.style.display = 'none');
    
    // Initialisation des valeurs des select
    document.querySelectorAll('select').forEach(select => select.dataset.default = select.value);
});