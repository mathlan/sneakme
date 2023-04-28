<div class="add">
    Ajout Réponse
    <form action="{{ route('answers.store') }}" method="post">
        @csrf
        <input type="text" name="name" placeholder="Nom de la categorie">
        <button type="submit">Ajouter</button>
    </form>
</div>
