<x-app-layout>
    <div class="create-main-box">
        <div class="add">
            <h2 class="create-title-form">{{ $product->name }}</h2>
            <div class="create-form">
                <img src="{{ asset( 'storage/product/' . $product->image) }}" width="350" height="350">
                <div class="flex flex-col">
                    <strong>Description</strong>
                    <p> {{ $product->description }} </p>
                </div>
                <div class="flex flex-col">
                    <strong>Prix</strong>
                    <p> {{ $product->price }} € </p>
                </div>
                <div class="flex flex-col">
                    <strong>Catégorie</strong>
                    <p> {{ $product->category->name}} </p>
                </div>
                <div class="flex w-3/4 justify-between">
                    <div class="flex flex-col">
                        <strong>Créer le</strong>
                        <p> {{ $product->created_at }} </p>
                    </div>
                    <div class="flex flex-col">
                        <strong>Modifier le</strong>
                        <p> {{ $product->updated_at }} </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
