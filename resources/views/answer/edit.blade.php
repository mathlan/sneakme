<form action="{{ route('answers.update',$answer) }}" method="post">
    @csrf
    @method('PUT')
    <input type="text" name="name" id="name" class="form-control" value="{{ $answer->name}}">
    <button type="submit" class="btn btn-primary">Modifier</button>
</form>
