<form action="{{ route('categories.update',$category) }}" method="post">
    @csrf
    @method('PUT')
    <input type="text" name="name" id="name" class="form-control" value="{{ $category->name}}">
    <button type="submit" class="btn btn-primary">Modifier</button>
</form>
