<x-app-layout>
        <section class="child-dash-menu">
            <h2>Produit</h2>
            <div class="update">
                <div class="update-box">
                    <p>Modifier le produit</p>
                    <a href="{{ route('product.create') }}"><i class="fa-solid fa-plus"></i> Ajouter un produit</a>
                </div>
                <div class="all-box">
                    <p>Nombre de produits :</p>
                    <?php
                    $all = count($products);
                    echo '<p class="nbr-all">' . $all . '</p>';
                    ?>
                </div>
                <ul class="list-all" id="paginated-list" data-current-page="1">
                    @foreach ($products as $product)
                        <hr>
                        <li class="list-item-product" value="{{ $product-> id }}"><a class="name-list-item" href="{{ route('product.show', $product) }}">{{ $product-> name }}</a>
                        <div class="product-crud">
                            <a href="{{ route('product.show', $product) }}">Voir</a>
                            <a class="btn-update" href="{{ route('product.edit', $product) }}"><span>Modifier <i class="fa-solid fa-wrench"></i></span></a>
                            <form action="{{ route('product.destroy', $product) }}" method="post" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"><span>Supprimer<i class="fa-solid fa-trash"></i></span></button>
                            </form>
                        </div>
                        </li>
                        <hr>
                    @endforeach
                </ul>
            </div>
        </section>
</x-app-layout>
