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
                    <td>{{ utilisateur.privilege }}</td>
                    <td>{{ utilisateur.nom }}</td>
                    </tr>
                {% endfor %}
            </table>
            <br><br>
            
        </div>
        <a href="{{path}}utilisateur/create" class="btn-add">Ajouter</a>
</body>
</html>