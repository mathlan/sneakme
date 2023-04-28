<x-app-layout>
    <h1> {{ $product->name }} </h1>
    <img src="{{ Storage::path($product->image) }}">
    <p>Chemin de l'image : {{ Storage::path($product->image) }}</p>
    <h2> {{ $product->description }} </h2>
    <h2> {{ $product->price }} </h2>
    <h2> {{ $product->category->name}} </h2>
    <h2> {{ $product->created_at }} </h2>
    <h2> {{ $product->updated_at }} </h2>
</x-app-layout>
