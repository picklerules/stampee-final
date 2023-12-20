{{ include('header.php', {title: 'Enchère'}) }}
<a href="{{path}}mise/index" class="btn">Voir mes mises</a>
<span class="text-danger">{{ errors | raw }}</span>

  <main class="enchere">

  {% for enchere in encheres %}
    <div class="enchere-container">
      <article class="item-enchere">

        <div class="image-container">
          <img class="img-enchere" src="{{path}}uploads/{{ enchere.file }}" alt="{{ enchere.nom }}">
        </div>
        <div class="enchere-container">

          <h2><a href="#">{{ enchere.nom }} {{ enchere.enchereId}} </a></h2>
          
          <div class="details-timbre-container">
         
            <button class="btn"><i class="fa-solid fa-star fa-lg"></i></button>
            <div class="info-box">{{ enchere.pays }}</div>
              <div class="info-box">Prix de départ: {{ enchere.prix_min }} $</div>
              <div class="info-box">Date de début: {{ enchere.date_debut }} </div>
              <div class="info-box">Date de fin: {{ enchere.date_fin }} </div>
              <form action="{{path}}mise/store" method="post">  
                  <input type="text" name="prix_offert" class="input-miser" placeholder="{{ enchere.max_mise ? enchere.max_mise ~ ' $ CAD' : enchere.prix_min ~ ' $ CAD' }} ">
                  <input type="hidden" name="prix_min" value="{{ enchere.prix_min }}">
                  <input type="hidden" name="id_enchere" value="{{ enchere.enchereId }}">
                  <button type="submit" class="btn">Miser</button>
              </form>
                          
            </div>

          </div>
   
        </article>
      </div>
      {% endfor %}  
<!-- 
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
   -->

    
    </main>
    
    {{ include('footer.php') }}