export default class Filtres {
    constructor(el) {
        this._el = el;
        this._elEncheresContainer = document.querySelector('.enchere');
        this.init();
    }
    
    init() {
        this._el.querySelectorAll('[data-js-filtre]').forEach(categorieEl => {
            categorieEl.addEventListener('click', () => {
                let categorie = categorieEl.dataset.jsFiltre;
                this.filterByCategorie(categorie);
            });
        });
    }
    
        filterByCategorie(categorie) {
            let data = {
                action: 'filterByCategorie',
                categorie: categorie
            };
    
            let oOptions = {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            };
    
            fetch('/stampee-pw1/requetes/requetesAsync.php', oOptions)
            .then(response => {
                if (response.ok) return response.json();
                else throw new Error('La réponse n\'est pas ok');
            })
            .then(data => {
                this._elEncheresContainer.innerHTML = ''; // Clear the container
    
                data.forEach(enchereData => {
                    console.log(enchereData); 
                    let html = this.createEnchereHtml(enchereData);
                    this._elEncheresContainer.innerHTML += html;
                });
            })
            .catch(error => {
                console.error('Fetch error:', error);
            });
        }
    
        createEnchereHtml(data) {

            let imagePath = '/stampee-pw1/uploads/' + data.file; 
        
            return `
                <article class="item-enchere">
                    <div class="image-container">
                        <img class="img-enchere" src="${imagePath}" alt="${data.nom}">
                    </div>
                    <div class="enchere-details-container">
                        <h2><a href="#">${data.nom}</a></h2>
                        <div class="details-timbre-container">
                            <!-- Bouton favoris -->
                            <form action="" method="post">
                                <input type="hidden" name="id_enchere" value="${data.id}">
                                <button type="button" class="btn remove-favorite" data-encherid="${data.id}" data-js-component="Favoris">
                                    <i class="fa-solid fa-star fa-lg"></i>
                                </button>
                            </form>
                            <div class="info-box">${data.pays}</div>
                            <div class="info-box">${data.categorie}</div>
                            <div class="info-box">Prix de départ: ${data.prix_min} $</div>
                            <div class="info-box">État: ${data.etat}</div>
                            <div class="info-box">Couleur: ${data.couleur}</div>
                            <div class="info-box">Date de début: ${data.date_debut}</div>
                            <div class="info-box">Date de fin: ${data.date_fin}</div>
                            <!-- Add any other details that you have and need to display -->
                        </div>
                    </div>
                </article>`;
        }
    }
    