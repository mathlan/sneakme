<x-app-layout>
    <div class="create-main-box">
        <div class="add">
            <h2 class="create-title-form">Modifier le produit</h2>
            <form class="create-form" action="{{ route('categories.update',$category) }}" method="post">
                @csrf
                @method('PUT')
                <div class="flex flex-col input-box">
                    <span>Nom de la catégorie</span>
                    <input type="text" name="name" id="name" class="form-control" value="{{ $category->name}}">
                </div>
                <button type="submit" class="create-button-add">Modifier</button>
            </form>
        </div>
    </div>
</x-app-layout>
