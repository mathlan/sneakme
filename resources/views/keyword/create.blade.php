<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>
    <link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet"/>
</head>

<div class="add">
    Ajout Mot Clé
    <form action="{{ route('keyword.store') }}" method="post">
        @csrf
        <input type="text" name="name" placeholder="Nom de la categorie">
        <select name="answer_id" id="answer_id" class="form-control" multiple>
            @foreach ($answers as $answer)
                <option value="{{ $answer->id }}" {{ old('category_id') == $answer->id ? 'selected' : '' }}>{{ $answer->name }}</option>
            @endforeach
        </select>
        <button type="submit">Ajouter</button>
    </form>
</div>
