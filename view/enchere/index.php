{{ include('header.php', {title: 'Enchère'}) }}
<a href="{{path}}mise/index" class="btn">Voir mes mises</a>

  <!-- Formulaire de recherche -->
  <form action="{{path}}enchere/search" method="POST">
      <input type="text" name="keyword" placeholder="Recherche d'enchères..." value="{{ searchKeyword | default('') }}">
      <button type="submit" class="btn">Rechercher</button>
      <span class="text-danger">{{ errors | raw }}</span>
    </form>

  <main class="enchere">

  {% for enchere in encheres %}
    <div class="enchere-container">
      <article class="item-enchere">

        <div class="image-container">
          <img class="img-enchere" src="{{path}}uploads/{{ enchere.file }}" alt="{{ enchere.nom }}">
        </div>
        <div class="enchere-container">

          <h2><a href="#">{{ enchere.nom }} </a></h2>
          
          <div class="details-timbre-container">  
                <!-- bouton favoris -->
                {% if enchere.estFavoris %}
                  <form action="" method="post">
                    <input type="hidden" name="id_enchere" value="{{ enchere.enchereId }}">
                    <button type="button" class="btn remove-favorite" data-encherid="{{ enchere.enchereId }}" data-js-component="Favoris"><i class="fa-solid fa-star fa-lg"></i></button>
                  </form>
                {% else %}
                  <form action="" method="post">
                    <input type="hidden" name="id_enchere" value="{{ enchere.enchereId }}">
                    <button type="button" class="btn add-favorite" data-encherid="{{ enchere.enchereId }}"  data-js-component="Favoris"><i class="fa-regular fa-star fa-lg"></i></button>
                  </form>
                {% endif %}

            <div class="info-box">{{ enchere.pays }}</div>
            <div class="info-box">{{ enchere.categorie }}</div>
              <div class="info-box">Prix de départ: {{ enchere.prix_min }} $</div>
              <div class="info-box">Prix actuel: {{ enchere.max_mise }} $</div>
              <div class="info-box">Date de début: {{ enchere.date_debut }} </div>
              <div class="info-box">Date de fin: {{ enchere.date_fin }} </div>
              <form action="{{path}}mise/store" method="post">  
                  <input type="text" name="prix_offert" class="input-miser" placeholder="{{ enchere.max_mise ? enchere.max_mise ~ ' $' : enchere.prix_min ~ ' $' }}">
                  <input type="hidden" name="id_enchere" value="{{ enchere.enchereId }}">
                  <button type="submit" class="btn">Miser</button>

                  {% if bidErrors[enchere.enchereId] %}
                    {% for bidError in bidErrors[enchere.enchereId] %}
                        <div class="error-message">{{ bidError }}</div>
                    {% endfor %}
                  {% endif %}


              </form>
              {% if enchere.id_utilisateur == session.id %}
              <form action="{{path}}enchere/destroy" method="post">
                <input type="hidden" name="id" value="{{ enchere.enchereId }}">
                <button type="submit" class="btn">Supprimer</button>
              </form> 
              <a href="{{path}}enchere/edit/{{ enchere.enchereId }}" class="btn">Modifier</a>
              {% endif %}         
            </div>

          </div>
   
        </article>
      </div>
      {% endfor %}  

    
    </main>
    
    {{ include('footer.php') }}