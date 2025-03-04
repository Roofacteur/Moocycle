document.addEventListener('DOMContentLoaded', function() {
    const hamMenu = document.querySelector('.ham-menu');
    const offScreenMenu = document.querySelector('.off-screen-menu');
    const overlay = document.querySelector('.menu-overlay');
    const confirmButton = document.getElementById('dialog-confirm');
    const cancelButton = document.getElementById('dialog-cancel');
    const dialogTitle = document.getElementById('dialog-title');
    const customDialog = document.getElementById('custom-dialog');
    const dialogMessage = document.getElementById('dialog-message');
    let selectedCowId;
    let deleteUrl = '';

    if (hamMenu && offScreenMenu && overlay) {
        hamMenu.addEventListener('click', () => {
            hamMenu.classList.toggle('active');
            offScreenMenu.classList.toggle('active');
            overlay.classList.toggle('active');
        });

        overlay.addEventListener('click', () => {
            hamMenu.classList.remove('active');
            offScreenMenu.classList.remove('active');
            overlay.classList.remove('active');
        });
    }

    document.body.addEventListener('click', function(event) {
        const target = event.target;

        if (target.matches('.lactation-btn')) {
            selectedCowId = target.dataset.cowId;
            const cowName = target.closest('li').dataset.cowName;
            const cowLactation = target.dataset.cowLactation;
            dialogMessage.textContent = `Voulez-vous ajouter une lactation à ${cowName} ? Nombre de lactations actuel : ${cowLactation}`;
            confirmButton.dataset.action = 'increment-lactation';
            customDialog.style.display = 'flex';
        }

        if (target.matches('.chaleur-btn')) {
            selectedCowId = target.dataset.cowId;
            const cowName = target.closest('li').dataset.cowName;
            dialogMessage.textContent = `${cowName} est en chaleur ?`;
            confirmButton.dataset.action = 'add-latest-date';
            customDialog.style.display = 'flex';
        }
        

        if (target.matches('.delete-btn')) {
            event.preventDefault();
            const cowName = target.dataset.cowName;
            deleteUrl = target.dataset.deleteHref;
            if (!deleteUrl) return console.error("URL de suppression manquante.");
            dialogMessage.textContent = `Voulez-vous vraiment supprimer ${cowName} ?`;
            customDialog.style.display = 'flex';
        }
    });

    document.getElementById('btn-chaleur')?.addEventListener('click', function() {
        confirmButton.dataset.action = 'add-latest-date';
        customDialog.style.display = 'block';
    });

    confirmButton?.addEventListener('click', function() {
        if (selectedCowId && confirmButton.dataset.action === 'add-latest-date') {
            fetch(`/health/${selectedCowId}/add-latest-date`, {
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
            
            customDialog.style.display = 'none';
        } 
        else if (selectedCowId && confirmButton.dataset.action === 'increment-lactation') {
            fetch(`/health/${selectedCowId}/increment-lactation`, {
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
            });
            customDialog.style.display = 'none';
        } else if (deleteUrl) {
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
    });
    

    cancelButton?.addEventListener('click', function(event) {
        const form = document.querySelector('form');
        if (!form) return;

        const isDirty = [...form.elements].some(input => {
            return input.tagName === 'SELECT' ? input.value !== input.dataset.default : input.value !== input.defaultValue;
        });

        if (isDirty) {
            event.preventDefault();
            customDialog.style.display = 'flex';
            dialogTitle.textContent = "Attention";
            dialogMessage.textContent = "Vos changements ne seront pas enregistrés. Voulez-vous vraiment quitter ?";
        } else {
            window.location.href = cancelButton.href;
        }
    });

    cancelButton?.addEventListener('click', () => customDialog.style.display = 'none');

    document.querySelectorAll('select').forEach(select => select.dataset.default = select.value);
});
