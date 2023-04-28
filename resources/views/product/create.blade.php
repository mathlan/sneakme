<div class="add">
    Ajout Produit
    <form action="{{ route('products.store') }}" method="post">
        @csrf
        <input type="text" name="name" placeholder="Nom du produit">
        <textarea name="description" placeholder="Description"></textarea>
        <input name="price" type="number" placeholder="Prix" min="1" max="200">
        <select name="category_id" id="category_id" class="form-control">
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
            @endforeach
        </select>
        <button type="submit">Ajouter</button>
    </form>
</div>
