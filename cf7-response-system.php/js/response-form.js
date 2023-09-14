document.addEventListener('DOMContentLoaded', function () {
    document.addEventListener('DOMContentLoaded', function () {
        var form = document.getElementById('response-form');
        var successMessage = document.getElementById('success-message');

        form.addEventListener('submit', function (event) {
            event.preventDefault();

            var formData = new FormData(form);

            // Envoi des données du formulaire via AJAX
            fetch(form.action, {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                // Cachez le formulaire et affichez le message de succès
                form.style.display = 'none';
                successMessage.style.display = 'block';
            })
            .catch(error => {
                console.error('Error:', error);
            });

            // Rediriger vers une URL personnalisée après 2 secondes
            setTimeout(function() {
                window.location.href = "https://exemple.fr"; // Remplacez par l'URL de votre choix
            }, 2000);
        });
		
    });

});
