{{ include('header.php', {title: 'Catalogue de timbre'}) }}


<main>

    <div class="liste">
    {% for timbre in timbres %}
        <article class="item">
          <img class="img-stamp" src="{{path}}uploads/{{ timbre.image_principale }}" alt="{{ timbre.nom }}" loading="lazy" >
          <h2><a href="#">{{ timbre.nom }}</a></h2>
            <a href="{{path}}enchere/index" class="btn">Miser</a>
        </article>
        {% endfor %}
  </div>

</main>

{{ include('footer.php') }}
