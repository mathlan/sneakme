<x-app-layout>
    <div class="create-main-box">
        <div class="add">
            <h2 class="create-title-form">Ajout Categorie</h2>
            <form class="create-form" action="{{ route('categories.store') }}" method="post">
                @csrf
                <div class="flex flex-col input-box">
                    <span>Nom de la categorie</span>
                    <input type="text" name="name">
                </div>
                <button class="create-button-add" type="submit">Ajouter</button>
            </form>
        </div>
    </div>
</x-app-layout>
