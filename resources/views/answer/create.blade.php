<x-app-layout>
    <div class="create-main-box">
        <div class="add">
            <h2 class="create-title-form">Ajout Réponse</h2>
            <form class="create-form" action="{{ route('answers.store') }}" method="post">
                @csrf
                <div class="flex flex-col input-box">
                    <span>Nom de la réponse</span>
                    <input type="text" name="name">
                </div>
                <button class="create-button-add" type="submit">Ajouter</button>
            </form>
        </div>
    </div>
</x-app-layout>
