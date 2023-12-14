{{ include('header.php', {title: 'Catalogue de timbre'}) }}


<main>

    <div class="liste">
    {% for timbre in timbres %}
    {% if timbre.id_utilisateur == session.id %}
        <article class="item">
          
          <img class="img-stamp" src="{{path}}uploads/{{ timbre.file }}" alt="{{ timbre.nom }}" loading="lazy">

          <h2><a href="{{path}}timbre/show/{{ timbre.id }}">{{ timbre.nom }}</a></h2>
            <a href="{{path}}enchere/create" class="btn">Créer une enchère</a>
        </article>
    {% endif %}
    {% endfor %}
  </div>
  
  <a href="{{path}}timbre/create" class="btn">Ajouter un timbre</a>
</main>

{{ include('footer.php') }}
