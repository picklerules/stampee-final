{{ include('header.php', {title: 'Catalogue de timbre'}) }}


<main class="main-catalogue">
<a href="{{path}}timbre/create" class="btn">Ajouter un timbre</a>
    <div class="liste">
    {% for timbre in timbres %}
    {% if timbre.id_utilisateur == session.id %}
        <article class="item">
          
          <img class="img-stamp" src="{{path}}uploads/{{ timbre.file }}" alt="{{ timbre.nom }}" loading="lazy">

          <h2><a href="{{path}}timbre/show/{{ timbre.id }}">{{ timbre.nom }}</a></h2>
            <a href="{{path}}enchere/create" class="btn">Mettre en enchère</a>
            <a href="#" class="btn">Modifier</a>
            <a href="#" class="btn">Supprimer</a>
        </article>
    {% endif %}
    {% endfor %}
  </div>
  

</main>

{{ include('footer.php') }}
