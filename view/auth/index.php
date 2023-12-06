{{ include('header.php', {title: 'Login'}) }}
<body>
    <div class="form-container">
        <form action="{{path}}login/auth" method="post">
            <h3>Login</h3>
            <span class="text-danger">{{ errors | raw }}</span>
            <label>Utilisateur
                <input type="text" name="username" value="">
            </label>
            <label>Mot de passe
                <input type="password" name="password" value="">
            </label>
            <input type="submit" value="Connecter" class="btn">
        </form>
    </div>
</body>
</html>
{{ include('footer.php') }}
