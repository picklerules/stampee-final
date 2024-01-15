document.addEventListener('DOMContentLoaded', function() {
    // Gérer l'ajout aux favoris
    document.querySelectorAll('.add-favorite').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const enchereId = this.dataset.encherid;
            fetch('/stampee-pw1/requetes/requetesAsync.php', {
                method: 'POST',
                body: JSON.stringify({ action: 'addToFavoris', id_enchere: enchereId }),
                headers: { 'Content-Type': 'application/json' }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                   // changer le bouton 
                }
            })
            .catch((error) => { console.log(error); });
        });
    });

    // Gérer la suppression des favoris
    document.querySelectorAll('.remove-favorite').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const enchereId = this.dataset.encherid;
            fetch('/stampee-pw1/requetes/requetesAsync.php', {
                method: 'POST',
                body: JSON.stringify({ action: 'removeFromFavoris', id_enchere: enchereId }),
                headers: { 'Content-Type': 'application/json' }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // changer le bouton 
                }
            })
            .catch((error) => { console.log(error); });
        });
    });
});
