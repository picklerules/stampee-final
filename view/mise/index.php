{{ include('header.php', {title: 'Mes mises'}) }}

<main class="main-catalogue">
    <span class="text-danger">{{ errors | raw }}</span>
    {% for mise in mises %}
    <div class="liste">

    <article class="item">
        <h2>Mise sur timbre: {{ mise.nom }}</h2>
        <img class="img-stamp" src="{{path}}uploads/{{ mise.file }}" alt="{{ mise.nom }}" loading="lazy">
        <p>Montant Offert: {{ mise.prix_offert }}$</p>
        <p>Date et Heure: {{ mise.date_heure }}</p>
        <p>Par: {{ mise.username }}</p>
    </div>
    {% endfor %}
</main>

{{ include('footer.php') }}
