{{ include('header.php', {title: 'Timbre individuel'}) }}

  <main class="enchere">


    <div class="enchere-container">
      <article class="item-enchere">
        <div class="image-container">
          <img class="img-enchere" src="./assets/img/timbre.png" alt="{{ timbre.nom }}">
        </div>
        <div class="enchere-container">
          <h2><a href="#">{{ timbre.nom }}</a></h2>
          
          <div class="details-timbre-container">
            <button class="btn"><i class="fa-solid fa-star fa-lg"></i></button>
              <div class="info-box">{{ pays_origine.pays }}</div>
              <div class="info-box"> {{ date_creation.date }} </div>
              <div class="info-box"> {{ etat.etat }} </div>
              <div class="info-box"> {{ categorie.categorie }} </div>
              <form>  
                <input type="text" class="input-miser" placeholder="{{ enchere.prix_min }} $ CAD">
                <input type="button" value="Miser" class="btn">
              </form>           
            </div>
          </div>
        </article>
      </div>
  

    

    </main>
    
    {{ include('footer.php') }}