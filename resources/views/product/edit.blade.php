<x-app-layout>
    <div class="create-main-box">
        <div class="add">
            <h2 class="create-title-form">Modifier le produit</h2>
            <form class="create-form" action="{{ route('products.update',$product) }}" method="post">
                @csrf
                @method('PUT')
                <div class="flex flex-col input-box">
                    <span>Nom du produit</span>
                    <input type="text" name="name" id="name" class="form-control" value="{{ $product->name}}">
                </div>
                <button class="create-button-add" type="submit">Modifier</button>
            </form>
        </div>
    </div>
</x-app-layout>
