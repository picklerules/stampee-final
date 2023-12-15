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
            {% if session.privilege == 1 %}
            <label>Privilege
                <select name="id_privilege">
                    <option value="">Selectionner un privilege</option>
                   {%  for privilege in privileges %}
                   <option value="{{ privilege.id}}" {% if privilege.id == utilisateur.id_privilege %} selected {% endif %}>{{ privilege.privilege }}</option>
                    {% endfor %}
                </select>
            </label>
            {% endif %}

            <input type="submit" value="sauvegarder" class="btn">
        </form>
    </div>
</body>
</html>