<x-app-layout>
    <div class="create-main-box">
        <div class="add">
            <h2 class="create-title-form">Ajout Produit</h2>
            <form class="create-form" action="{{ route('products.store') }}" method="post">
                @csrf
                <div class="w-full">
                    <div class="flex flex-col input-box">
                        <span>Nom du produit</span>
                        <input type="text" name="name">
                    </div>
                    <div class="flex flex-col input-box">
                        <span>Description du produit</span>
                        <textarea name="description"></textarea>
                    </div>
                    <div class="flex flex-col input-box">
                        <span>Prix</span>
                        <input class="product-price" name="price" type="number" min="1" max="200" placeholder="€">
                    </div>
                    <div class="flex flex-col input-box">
                        <span>Catégorie</span>
                        <select name="category_id" id="category_id" class="form-control">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <button class="create-button-add" type="submit">Ajouter</button>
            </form>
        </div>
    </div>
</x-app-layout>
