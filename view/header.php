<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="description" content="Page d'accueil du site Stampee pour mise aux enchères de timbre">
                <title>{{ title }}</title>
                <link rel="stylesheet" href="{{path}}assets/css/styles.css">
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
      <div class="modal">
        <div class="close-button">X</div>
        <div class="category"><a href="catalogue.html">Timbres du Monde</a></div>
        <div class="category"><a href="catalogue.html">Rares</a></div>
        <div class="category"><a href="catalogue.html">Nouveautés</a></div>
        <div class="category"><a href="catalogue.html">Éditions Limitées</a></div>
        <div class="category"><a href="catalogue.html">Thématiques</a></div>
        <div class="category"><a href="catalogue.html">Classiques</a></div>
        <div class="category"><a href="catalogue.html">Séries</a></div>
        <div class="category"><a href="catalogue.html">Ensembles</a></div>
        <div class="category"><a href="catalogue.html">Usagés</a></div>
        <div class="category"><a href="catalogue.html">Comme neufs</a></div>
        <div class="category"><a href="catalogue.html">En stock</a></div>
        <div class="category"><a href="catalogue.html">Archives</a></div>
    </div>
      <nav>
          <ul>
              <li><a href="{{path}}" class="actif">Accueil</a></li>
              <li><a href="{{path}}timbre/index">Catalogue</a></li>
              {% if guest %}
              <li><a href="{{path}}login">Se connecter</a></li>
              {% else %}
              <li><a href="{{path}}timbre/create">Ajouter un timbre</a>
              <li><a href="{{path}}login/logout">Déconnection</a></li>
              {% if session.privilege == 1 %}
              <li><a href="{{path}}utilisateur">Utilisateurs</a></li>
              {% endif %}
              <li><a href="{{path}}login/logout">Logout</a></li>
              {% endif %}
              
          </ul>
      </nav>
</header>
