{{ include('header.php', {title: 'Login'}) }}
<body class="user">
    <h1 class="title">Se connecter</h1>
    <div class="form-container">
        <form action="{{path}}login/auth" method="post">
            <span class="text-danger">{{ errors | raw }}</span>
            <label>Nom d'utilisateur :
                <input type="text" name="username" value="">
            </label>
            <label>Mot de passe :
                <input type="password" name="password" value="">
            </label>
            <input type="submit" value="Connecter" class="btn">
        </form>
    </div>
</body>
</html>
{{ include('footer.php') }}
