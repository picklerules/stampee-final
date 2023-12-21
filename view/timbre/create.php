{{ include('header.php', {title: 'Ajouter un timbre'}) }}
<body>
    <div class="form-container">
        <form action="{{path}}timbre/store" method="post" enctype="multipart/form-data">
        <span class="text-danger">{{ errors | raw }}</span>

            <label>Nom
                <input type="text" name="nom">
            </label>

            <label>Date de création
                <input type="date" name="date_creation">
            </label>

            <label>Dimensions
                <input type="text" name="dimensions">
            </label>

            <label>Tirage
                <input type="text" name="tirage">
            </label>

            <label>Condition
                <select name="id_etat">
                    <option value="">Selectionner une condition</option>
                   {%  for etat in etats %}
                   <option value="{{ etat.id}}"> {{ etat.etat }}</option>
                    {% endfor %}
                </select>
            </label>

            <label>Pays d'origine
                <select name="id_pays_origine">
                    <option value="">Selectionner un pays</option>
                   {%  for pays in pays %}
                   <option value="{{ pays.id}}">{{ pays.pays }}</option>
                    {% endfor %}
                </select> 
            </label>

            <label>Catégorie
                <select name="id_categorie">
                    <option value="">Selectionner une catégorie</option>
                   {%  for categorie in categories %}
                   <option value="{{ categorie.id}}">{{ categorie.categorie }}</option>
                    {% endfor %}
                </select>
            </label>

            <label>Couleur
                <select name="id_couleur">
                    <option value="">Selectionner une couleur</option>
                   {%  for couleur in couleurs %}
                   <option value="{{ couleur.id}}">{{ couleur.couleur }}</option>
                    {% endfor %}
                </select>
            </label>

            <label>Cochez cette case si le timbre est certifié
                <input type="checkbox" name="certifie" value="1" {% if timbre.certifie %} checked {% endif %}>
            </label>

            <label>Images
                <input type="file" name="images[]" multiple>
            </label>
            
            <input type="submit" name="submit" value="Soumettre">

        </form>
        
    </div>
</body>
</html>
