{{ include('header.php', {title: 'Modifier une enchère'}) }}
<body>
    <div class="form-container">
        <form action="{{path}}enchere/update" method="post" >
        <span class="text-danger">{{ errors | raw }}</span>
        <input type="hidden" name="id" value="{{ enchere.enchereId }}">

        <h2 class="info-box">Timbre en enchère: {{ enchere.nom }}</h2>

        <label for="prix_min">Prix de départ</label>
        <input type="number" min="0" step="1.00" id="prix_min" name="prix_min" value="{{ enchere.prix_min}}">
        <label for="date_debut">Date de début</label>
        <input type="date" id="date_debut" name="date_debut" value="{{ enchere.date_debut | date('Y-m-d') }}">
        <label for="date_fin">Date de fin</label>
        <input type="date" id="date_fin" name="date_fin" value="{{ enchere.date_fin | date('Y-m-d') }}">

        <input type="submit" name="submit" value="Modifier l'enchère" class="btn">

        </form>
        
    </div>
{{ include('footer.php') }}
