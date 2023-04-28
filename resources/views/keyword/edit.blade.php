<form action="{{ route('keywords.update',$keyword) }}" method="post">
    @csrf
    @method('PUT')
    <input type="text" name="name"  value="{{ $keyword->name}}">
    <select name="answer_id" id="answer_id" class="form-control">
        @foreach ($answers as $answer)
            <option value="{{ $answer->id }}" {{ old('category_id') == $answer->id ? 'selected' : '' }}>{{ $answer->name }}</option>
        @endforeach
    </select>
    <button type="submit">Ajouter</button>
</form>
