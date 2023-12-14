{{ include('header.php', {title: 'Enchère'}) }}

  <main class="enchere">


    <div class="enchere-container">
      <article class="item-enchere">
      {% for enchere in encheres %}
        <div class="image-container">
          <img class="img-enchere" src="{{path}}uploads/{{ enchere.file }}" alt="{{ enchere.nom }}">
        </div>
        <div class="enchere-container">

          <h2><a href="#">{{ enchere.nom }}</a></h2>
          
          <div class="details-timbre-container">
         
            <button class="btn"><i class="fa-solid fa-star fa-lg"></i></button>
            <div class="info-box">{{ enchere.pays }}</div>
              <!-- <div class="info-box">{{ enchere.tirage }} exemplaires</div>
              <div class="info-box">{{ enchere.dimensions }} cm</div>
              <div class="info-box"> {{ enchere.date_creation }} </div>
              <div class="info-box"> {{ enchere.etat }} </div> -->
              <!-- <div class="info-box"> {{ enchere.categorie }} </div> -->
              <div class="info-box">Prix de départ: {{ enchere.prix_min }} $</div>
              <div class="info-box">Date de début: {{ enchere.date_debut }} </div>
              <div class="info-box">Date de fin: {{ enchere.date_fin }} </div>
              <form>  
                <input type="text" class="input-miser" placeholder="{{ enchere.prix_min }} $ CAD">
                <input type="button" value="Miser" class="btn">
              </form>   
             
            </div>

          </div>
          {% endfor %}     
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