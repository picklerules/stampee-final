{{ include('header.php', {title: 'Timbre individuel'}) }}

  <main class="enchere">


    <div class="enchere-container">
      <article class="item-enchere">
        <div class="image-container">
          <img class="img-enchere" src="{{path}}uploads/{{ timbre.file }}" alt="{{ timbre.nom }}">
        </div>
        <div class="enchere-container">
          <h2>{{ timbre.nom }}</h2>
          
          <div class="details-timbre-container">
            <button class="btn"><i class="fa-solid fa-star fa-lg"></i></button>
              <div class="info-box">{{ timbre.pays }}</div>
              <div class="info-box">{{ timbre.couleur }}</div>
              <div class="info-box">{{ timbre.tirage }} exemplaires</div>
              <div class="info-box">{{ timbre.dimensions }} cm</div>
              <div class="info-box"> {{ timbre.date_creation }} </div>
              <div class="info-box"> {{ timbre.etat }} </div>
              <div class="info-box"> {{ timbre.categorie }} </div>
              <form>  
              <a href="{{path}}enchere/create/{{ timbre.id }}" class="btn">Mettre en enchère</a>
              </form>           
              <a href="{{path}}timbre/edit/{{ timbre.id }}" class="btn">Modifier</a>
              <form action="{{path}}timbre/destroy" method="post">
                <input type="hidden" name="id" value="{{ timbre.id }}">
                <button type="submit" class="btn">Supprimer</button>
              </form>
            </div>
          </div>
        </article>
      </div>


    
    </main>
    
    {{ include('footer.php') }}