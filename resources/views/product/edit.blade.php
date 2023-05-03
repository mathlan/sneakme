<x-app-layout>
    <div class="create-main-box">
        <div class="add">
            <h2 class="create-title-form">Modifier le produit</h2>
            <form class="create-form" action="{{ route('products.update',$product) }}" method="post" enctype='multipart/form-data'>
                @csrf
                @method('PUT')
                <div class="w-full">
                    <div class="flex flex-col input-box">
                        <span>Nom du produit</span>
                        <input type="text" name="name" id="name" class="form-control" value="{{ $product->name}}">
                    </div>
                    <div class="flex flex-col input-box">
                        <span>Image du produit</span>
                        <input type="file" accept="image/*" name="image-file">
                    </div>
                    <div class="flex flex-col input-box">
                        <span>Description du produit</span>
                        <textarea name="description">{{ $product->description }}</textarea>
                    </div>
                    <div class="flex flex-col input-box">
                        <span>Prix</span>
                        <input class="product-price" name="price" type="number" min="1" max="2000" placeholder="€" value="{{ $product->price }}">
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
                <button class="create-button-add" type="submit">Modifier</button>
            </form>
        </div>
    </div>
</x-app-layout>
