<?php
enum KeywordTypes: string
{
    case default = 'default';
    case catalogue = 'catalogue';
    case panier = 'panier';
    case inscrire = 'inscrire';
    case compte = 'compte';
}

$tests = KeywordTypes::cases();

?>

<div class="add">
    Ajout Mot Clé
    <form action="{{ route('keywords.store') }}" method="post">
        @csrf
        <input type="text" name="name" placeholder="Nom de la categorie">
        <select name="answer_id" id="answer_id" class="form-control">
            @foreach ($answers as $answer)
                <option value="{{ $answer->id }}" {{ old('category_id') == $answer->id ? 'selected' : '' }}>{{ $answer->name }}</option>
            @endforeach
        </select>

        <select name="type" id="keywordType" class="form-control">
            @foreach ($tests as $test)
                <option value="{{ $test }}" {{ old('type') == $test ? 'selected' : '' }}>{{ $test }}</option>
            @endforeach
        </select>

        <button type="submit">Ajouter</button>
    </form>
</div>
