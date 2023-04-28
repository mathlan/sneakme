<x-app-layout>
    <div class="create-main-box">
        <div class="add">
            <h2 class="create-title-form">Modifier le produit</h2>
            <form class="create-form" action="{{ route('answers.update',$answer) }}" method="post">
                @csrf
                @method('PUT')
                <div class="flex flex-col input-box w-full">
                    <span>Nom de la réponse</span>
                    <input type="text" name="name" id="name" class="form-control answer-box" value="{{ $answer->name}}">
                </div>
                <button type="submit" class="create-button-add">Modifier</button>
            </form>
        </div>
    </div>
</x-app-layout>
