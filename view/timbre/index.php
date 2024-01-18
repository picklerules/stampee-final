{{ include('header.php', {title: 'Catalogue de timbre'}) }}


<main class="main-catalogue">

<!-- Formulaire de recherche -->
<form action="{{path}}timbre/search" method="POST">
  <input type="text" name="keyword" placeholder="Recherche de timbres..." value="{{ searchKeyword | default('') }}">
  <button type="submit" class="btn">Rechercher</button>
</form>

<a href="{{path}}timbre/create" class="btn">Ajouter un timbre</a>
<span class="text-danger">{{ errors | raw }}</span>
    <div class="liste">
    {% for timbre in timbres %}
    {% if timbre.id_utilisateur == session.id %}
        <article class="item">
          
          <img class="img-stamp" src="{{path}}uploads/{{ timbre.file }}" alt="{{ timbre.nom }}" loading="lazy">

          <h2><a href="{{path}}timbre/show/{{ timbre.id }}">{{ timbre.nom }}</a></h2>
            <a href="{{path}}enchere/create/{{ timbre.id }}" class="btn">Mettre en enchère</a>
            <a href="{{path}}timbre/edit/{{ timbre.id }}" class="btn">Modifier</a>
            <form action="{{path}}timbre/destroy" method="post">
                <input type="hidden" name="id" value="{{ timbre.id }}">
                <button type="submit" class="btn">Supprimer</button>
            </form>
        </article>
    {% endif %}
    {% endfor %}
  </div>
  

</main>

{{ include('footer.php') }}
