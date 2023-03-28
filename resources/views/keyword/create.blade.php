<div class="add">
    Ajout Mot Clé
    <form action="{{ route('keyword.store') }}" method="post">
        @csrf
        <input type="text" name="name" placeholder="Nom de la categorie">
        <select name="answer_id" id="answer_id" class="form-control">
            @foreach ($answers as $answer)
                <option value="{{ $answer->id }}" {{ old('category_id') == $answer->id ? 'selected' : '' }}>{{ $answer->name }}</option>
            @endforeach
        </select>
        <button type="submit">Ajouter</button>
    </form>
</div>
