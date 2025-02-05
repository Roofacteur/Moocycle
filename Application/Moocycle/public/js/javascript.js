document.addEventListener('DOMContentLoaded', function() {
    var customDialog = document.getElementById('custom-dialog');
    var dialogConfirm = document.getElementById('dialog-confirm');
    var dialogCancel = document.getElementById('dialog-cancel');
    var dialogTitle = document.getElementById('dialog-title');
    var dialogMessage = document.getElementById('dialog-message');
    const confirmButton = document.getElementById('dialog-confirm');
    const cancelButton = document.getElementById('dialog-cancel');
    const hamMenu = document.querySelector('.ham-menu');
    const offScreenMenu = document.querySelector('.off-screen-menu');
    const overlay = document.querySelector(".menu-overlay");    
    let deleteUrl = '';

    if (hamMenu && offScreenMenu && overlay) {
        hamMenu.addEventListener('click', function() {
            hamMenu.classList.toggle('active');
            offScreenMenu.classList.toggle('active');
            overlay.classList.toggle("active");
        });

        overlay.addEventListener("click", () => {
            hamMenu.classList.remove("active");
            offScreenMenu.classList.remove("active");
            overlay.classList.remove("active");
        });
    }

    if (dialogConfirm) {
        dialogConfirm.addEventListener('click', function() {
            if (typeof deleteForm !== "undefined" && deleteForm) {
                deleteForm.submit();
            }
        });
    }

    if (dialogCancel && customDialog) {
        dialogCancel.addEventListener('click', function() {
            customDialog.style.display = 'none';
        });
    }

    if (cancelButton) {
        cancelButton.addEventListener('click', function(event) {
            var form = document.querySelector('form');
            if (!form) return;

            var inputs = form.querySelectorAll('input, select');
            var isDirty = false;

            inputs.forEach(function(input) {
                if (input.tagName === 'SELECT') {
                    if (input.value !== input.getAttribute('data-default')) {
                        isDirty = true;
                    }
                } else {
                    if (input.value !== input.defaultValue) {
                        isDirty = true;
                    }
                }
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
    }

    var selects = document.querySelectorAll('select');
    selects.forEach(function(select) {
        select.setAttribute('data-default', select.value);
    });

    document.body.addEventListener('click', function (event) {
        if (event.target && event.target.matches('.delete-btn')) {
            event.preventDefault(); // Empêcher la redirection immédiate

            const cowName = event.target.getAttribute('data-cow-name');
            deleteUrl = event.target.getAttribute('data-delete-href');

            if (!deleteUrl) {
                console.error("URL de suppression manquante.");
                return;
            }

            dialogMessage.textContent = `Voulez-vous vraiment supprimer ${cowName} ?`;
            customDialog.style.display = 'flex';
        }
    });

    confirmButton.addEventListener('click', function () {
        if (!deleteUrl) return;

        // Création d'un formulaire pour envoyer la requête DELETE
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = deleteUrl;

        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';

        form.appendChild(csrfToken);
        form.appendChild(methodInput);

        document.body.appendChild(form);
        form.submit();
    });

    cancelButton.addEventListener('click', function () {
        customDialog.style.display = 'none';
    });
});