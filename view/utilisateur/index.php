{{ include('header.php', {title: 'Liste des utilisateurs'}) }}
<body>
    <h1>Utilisateurs</h1>
        <div class="table-container">
            <table>
                <tr>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Privilege</th>
                    <th>Timbre favori</th>

                </tr>
                {% for utilisateur in utilisateurs %}
                    <tr>
                    <td>{{ utilisateur.username }}</td>
                    <td>{{ utilisateur.email }}</td>
                    <td>{{ privilege.privilege }}</td>
                    <td>{{ timbre.nom }}</td>
                    </tr>
                {% endfor %}
            </table>
            <br><br>
            
        </div>
        <a href="{{path}}utilisateur/create">Ajouter</a>
</body>
</html>