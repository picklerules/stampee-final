export default class Favoris {
    constructor(button) {
        this.button = button;
        this.enchereId = button.dataset.encherid;
        this.initEvents();
    }

    initEvents() {
        this.button.addEventListener('click', () => {
            if (this.button.classList.contains('add-favorite')) {
                this.addToFavoris();
            } else {
                this.removeFromFavoris();
            }
        });
    }

    addToFavoris() {
        fetch('/stampee-pw1/requetes/requetesAsync.php', {
            method: 'POST',
            body: JSON.stringify({ action: 'addToFavoris', id_enchere: this.enchereId }),
            headers: { 'Content-Type': 'application/json' }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                this.updateButton(true);
                console.log(this.button.classList);
            }
        })
        .catch((error) => { console.log(error); });
    }

    removeFromFavoris() {
        fetch('/stampee-pw1/requetes/requetesAsync.php', {
            method: 'POST',
            body: JSON.stringify({ action: 'removeFromFavoris', id_enchere: this.enchereId }),
            headers: { 'Content-Type': 'application/json' }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                this.updateButton(false);
                console.log(this.button.classList);
            }
        })
        .catch((error) => { console.log(error); });
    }

    updateButton(isFavoris) {
        if (isFavoris) {
            this.button.innerHTML = '<i class="fa-solid fa-star fa-lg"></i>';
            this.button.classList.remove('add-favorite');
            this.button.classList.add('remove-favorite');
        } else {
            this.button.innerHTML = '<i class="fa-regular fa-star fa-lg"></i>';
            this.button.classList.remove('remove-favorite');
            this.button.classList.add('add-favorite');
        }
    }
}

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('[data-js-component="Favoris"]').forEach(button => {
        new Favoris(button);
    });
});
