{{ include('header.php', {title: 'Ajouter un utilisateur'}) }}
<body>
    <div class="form-container">
        <form action="{{path}}utilisateur/store" method="post">
            <span class="text-danger">{{ errors | raw }}</span>
            <label>Utilisateur
                <input type="text" name="username" value="{{utilisateur.username}}">
            </label>
            <label>Courriel
                <input type="email" name="email" value="">
            </label>
            <label>Mot de passe
                <input type="password" name="password" value="">
            </label>
            <label>Privilege
                <select name="id_privilege">
                    <option value="">Selectionner un privilege</option>
                   {%  for privilege in privileges %}
                   <option value="{{ privilege.id}}" {% if privilege.id == utilisateur.id_privilege %} selected {% endif %}>{{ privilege.privilege }}</option>
                    {% endfor %}
                </select>
            </label>
            <label>Timbre favori
                <select name="id_timbre_favori">
                    <option value="">Selectionner un timbre</option>
                   {%  for timbre in timbres %}
                   <option value="{{ timbre.id}}" {% if timbre.id == utilisateur.id_timbre_favori %} selected {% endif %}>{{ timbre.nom }}</option>
                    {% endfor %}
                </select>
            </label>
            <input type="submit" value="sauvegarder" class="btn">
        </form>
    </div>
</body>
</html>