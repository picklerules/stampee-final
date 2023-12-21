{{ include('header.php', {title: 'Ajouter une enchère'}) }}
<body>
    <div class="form-container">
        <form action="{{path}}enchere/store" method="post" >
        <span class="text-danger">{{ errors | raw }}</span>

        <label>Timbre à mettre à l'enchère
                <select name="id_timbre">
                    <option value="">Selectionner un timbre</option>
                   {%  for timbre in timbres %}
                   <option value="{{ timbre.id}}"selected> {{ timbre.nom }}</option>
                    {% endfor %}
                </select>
        </label>
        <label for="prix_min">Prix de départ</label>
        <input type="number" min="0" step="1.00" id="prix_min" name="prix_min" placeholder="0,00$">
        <label for="date_debut">Date de début</label>
        <input type="date" id="date_debut" name="date_debut">
        <label for="date_fin">Date de fin</label>
        <input type="date" id="date_fin" name="date_fin">
        <!-- <label>Coup de coeur
                <input type="checkbox" name="coup_de_coeur" value="1" {% if enchere.coup_de_coeur %} checked {% endif %}>
        </label>
     -->
        <input type="submit" name="submit" value="Publier l'enchère">

        </form>
        
    </div>
{{ include('footer.php') }}
