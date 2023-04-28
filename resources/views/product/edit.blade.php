<form action="{{ route('products.update',$product) }}" method="post">
    @csrf
    @method('PUT')
    <input type="text" name="name" id="name" class="form-control" value="{{ $product->name}}">
    <button type="submit" class="btn btn-primary">Modifier</button>
</form>
