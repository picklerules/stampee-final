{{ include('header.php', {title: 'Mes mises'}) }}

<main class="main-catalogue">
    <span class="text-danger">{{ errors | raw }}</span>
    <div class="liste">
        {% for mise in mises %}
            {% if mise.id_utilisateur == session.id %}
                <article class="item">
                    <h2>Mise sur Enchère ID: {{ mise.id_enchere }}</h2>
                    <p>Montant Offert: {{ mise.prix_offert }}$</p>
                    <p>Date et Heure: {{ mise.date_heure }}</p>
                    <p>Par: {{ mise.username }}</p>
                </article>
            {% endif %}
        {% endfor %}
    </div>
</main>

{{ include('footer.php') }}
