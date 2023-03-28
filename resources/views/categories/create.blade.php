<div class="add">
    Ajout Categorie
    <form action="{{ route('categories.store') }}" method="post">
        @csrf
        <input type="text" name="name" placeholder="Nom de la categorie">
        <button type="submit">Ajouter</button>
    </form>
</div>
