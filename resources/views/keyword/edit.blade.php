<x-app-layout>
    <div class="create-main-box">
        <div class="add">
            <h2 class="create-title-form">Modifier le mot clé</h2>
            <form  class="create-form" action="{{ route('keywords.update',$keyword) }}" method="post">
                @csrf
                @method('PUT')
                <div class="w-full">
                    <div class="flex flex-col input-box">
                        <span>Nom du mot clé</span>
                        <input type="text" name="name"  value="{{ $keyword->name}}">
                    </div>
                    <div class="flex flex-col input-box">
                        <span>Modifier la réponse</span>
                        <select name="answer_id" id="answer_id" class="form-control">
                            @foreach ($answers as $answer)
                                <option value="{{ $answer->id }}" {{ old('category_id') == $answer->id ? 'selected' : '' }}>{{ $answer->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <button class="create-button-add" type="submit">Ajouter</button>
            </form>
        </div>
    </div>
</x-app-layout>
