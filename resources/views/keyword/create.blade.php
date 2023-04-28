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
<x-app-layout>
    <div class="create-main-box">
        <div class="add">
            <h2 class="create-title-form">Ajout Mot Clé</h2>
            <form class="create-form" action="{{ route('keywords.store') }}" method="post">
                @csrf
                <div>
                    <div class="flex flex-col">
                        <span>Nom du mot clé</span>
                        <input type="text" name="name">
                    </div>
                    <div class="flex flex-col input-box">
                        <span>Réponse</span>
                        <select name="answer_id" id="answer_id" class="form-control">
                            @foreach ($answers as $answer)
                                <option value="{{ $answer->id }}" {{ old('category_id') == $answer->id ? 'selected' : '' }}>{{ $answer->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex flex-col input-box">
                        <span>Type</span>
                        <select name="type" id="keywordType" class="form-control">
                            @foreach ($tests as $test)
                                <option value="{{ $test }}" {{ old('type') == $test ? 'selected' : '' }}>{{ $test }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <button class="create-button-add" type="submit">Ajouter</button>

            </form>
        </div>
    </div>
</x-app-layout>
