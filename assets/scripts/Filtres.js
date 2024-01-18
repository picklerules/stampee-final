export default class Filtres {
    constructor(el) {
        this._el = el;
        this._elEncheresContainer = document.querySelector('.enchere-container');
        this._elTemplateEnchere = document.querySelector('[data-js-template-enchere]');
   
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
            if(response.ok) return response.json();
            else throw new Error('La réponse n\'est pas ok');
        })
        .then(function(data) {

            this._elEncheresContainer.innerHTML = '';
            console.log(data)

            for (let i = 0, l = data.length ; i < l; i++) {
                
                let elCloneTemplate = this._elTemplateEnchere.cloneNode(true);

                for (const cle in data[i]) {
                    // console.log(data[i])
                    let regex = new RegExp('{{' + cle + '}}', 'g');
                    elCloneTemplate.innerHTML = elCloneTemplate.innerHTML.replace(regex, data[i][cle]);    
                    
                }
                    
                    let elNewEnchere = document.importNode(elCloneTemplate.content, true);
                    this._elEncheresContainer.append(elNewEnchere);

                  //  new Enchere(this._elTaches.lastElementChild);
            }
        }.bind(this))  
}

}

