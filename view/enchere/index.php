{{ include('header.php', {title: 'Enchère'}) }}

  <main class="enchere">


    <div class="enchere-container">
      <article class="item-enchere">
        <div class="image-container">
          <img class="img-enchere" src="./assets/img/timbre.png" alt="timbre techno">
        </div>
        <div class="enchere-container">
          <h2><a href="#">{{ timbre.nom }}</a></h2>
          
          <div class="details-timbre-container">
            <button class="btn"><i class="fa-solid fa-star fa-lg"></i></button>
              <div class="info-box">{{ pays_origine.pays }}</div>
              <div class="info-box"> {{ date_creation.date }} </div>
              <div class="info-box"> {{ etat.etat }} </div>
              <div class="info-box"> {{ categorie.categorie }} </div>
              <div class="info-box">Prix de départ: {{ enchere.prix_min }} </div>
              <div class="info-box">Date de début: {{ enchere.date_debut }} </div>
              <div class="info-box">Date de fin: {{ enchere.date_fin }} </div>
              <form>  
                <input type="text" class="input-miser" placeholder="{{ enchere.prix_min }} $ CAD">
                <input type="button" value="Miser" class="btn">
              </form>           
            </div>
          </div>
        </article>
      </div>

      <div class="enchere-container">
        <article class="item-enchere">
          <div>
            <h2>Suggestions</h2>
            <div class="image-container">
              <a href="#"><img class="img-stamp" src="./assets/img/timbre3.png" alt="timbre fashion"></a>
            </div>  
            <form class="mise-rapise">  
              <input type="text" class="input-miser" placeholder="00,00 $ CAD">
              <input type="button" value="Mise rapide" class="btn">
            </form>           
            </div>
          </article>
        </div>
  

    

    </main>
    
    {{ include('footer.php') }}