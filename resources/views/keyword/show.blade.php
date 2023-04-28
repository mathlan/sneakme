<x-app-layout>
    <h1> {{ $keyword->name }} </h1>
    <h2> {{ $keyword->answer->name}} </h2>
    <h2> {{ $keyword->type}} </h2>
    <h2> {{ $keyword->created_at }} </h2>
    <h2> {{ $keyword->updated_at }} </h2>
</x-app-layout>
