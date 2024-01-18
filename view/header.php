<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="description" content="Page d'accueil du site Stampee pour mise aux enchères de timbre">
                <title>{{ title }}</title>

                <link rel="stylesheet" href="{{path}}assets/css/styles.css">

                <script src="https://kit.fontawesome.com/0f52bb4695.js" crossorigin="anonymous"></script>

                <script type="module" src="{{path}}assets/scripts/main.js" defer></script>
            </head>
            <body>
            <header>
      <input type="checkbox" id="menu-toggle">
      <label for="menu-toggle" class="menu-burger">
          <span></span>
          <span></span>
          <span></span>
      </label>
      <div class="site-name">
          STAMPEE
      </div>
      <div class="modal" data-js-component="Filtres">
        <div class="close-button">X</div>
        <div class="category" data-js-filtre="timbres du monde">Timbres du Monde</div>
        <div class="category" data-js-filtre="rares">Rares</div>
        <div class="category" data-js-filtre="nouveautes">Nouveautés</div>
        <div class="category" data-js-filtre="editions limitees">Éditions Limitées</div>
        <div class="category" data-js-filtre="thematiques">Thématiques</div>
        <div class="category" data-js-filtre="classiques">Classiques</div>
        <div class="category" data-js-filtre="series">Séries</div>
        <div class="category" data-js-filtre="ensembles">Ensembles</div>
        <div class="category" data-js-filtre="usages">Usagés</div>
        <div class="category" data-js-filtre="comme neufs">Comme neufs</div>
        <div class="category" data-js-filtre="en stock">En stock</div>
        <div class="category" data-js-filtre="archives">Archives</div>
    </div>
      <nav>
          <ul>
              <li><a href="{{path}}">Accueil</a></li>
              <li><a href="{{path}}enchere/index">Catalogue d'enchères</a></li>
              {% if guest %}
              <li><a href="{{path}}utilisateur/create">Devenir membre</a></li>
              <li><a href="{{path}}login">Se connecter</a></li>
              {% else %}
              <li><a href="{{path}}timbre/index">Mes timbres</a></li>
              {% if session.privilege == 1 %}
              <li><a href="{{path}}utilisateur">Utilisateurs</a></li>
              {% endif %}
              <li><a href="{{path}}login/logout">Déconnection</a></li>
              {% endif %}
              
          </ul>
      </nav>
</header>
