document.addEventListener('DOMContentLoaded', function() {
    // Gérer l'ajout aux favoris
    document.querySelectorAll('.add-favorite').forEach(function(btn) {
        btn.addEventListener('click', function() {

            const enchereId = this.dataset.encherid;
            const button = this;

            fetch('/stampee-pw1/requetes/requetesAsync.php', {

                method: 'POST',
                body: JSON.stringify({ action: 'addToFavoris', id_enchere: enchereId }),
                headers: { 'Content-Type': 'application/json' }
            })
            .then(response => response.json())
            .then(data => {

                if (data.success) {

                    button.innerHTML = '<i class="fa-solid fa-star fa-lg"></i>';
                    button.classList.remove('add-favorite');
                    button.classList.add('remove-favorite');
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

                    button.innerHTML = '<i class="fa-regular fa-star fa-lg"></i>';
                    button.classList.remove('remove-favorite');
                    button.classList.add('add-favorite');
                }
            })
            .catch((error) => { console.log(error); });
        });
    });
});

