<x-app-layout>
        <section class="child-dash-menu">
            <h2>Liste des produits</h2>
            <div class="update">
                <div class="update-box">
                    <div class="all-box">
                        <p>Nombre de produits :</p>
                        <?php
                        $all = count($products);
                        echo '<p class="nbr-all">' . $all . '</p>';
                        ?>
                    </div>
                    <a href="{{ route('products.create') }}"><i class="fa-solid fa-plus"></i> Ajouter un produit</a>
                </div>
                <ul class="list-all" id="paginated-list" data-current-page="1">
                    @foreach ($products as $product)
                        <hr>
                        <li class="list-item-product" value="{{ $product-> id }}"><a class="name-list-item" href="{{ route('products.show', $product) }}">{{ $product-> name }}</a>
                        <div class="product-crud">
                            <a href="{{ route('products.show', $product) }}">Voir</a>
                            <a class="btn-update" href="{{ route('products.edit', $product) }}"><span>Modifier <i class="fa-solid fa-wrench"></i></span></a>
                            <form action="{{ route('products.destroy', $product) }}" method="post" class="d-inline">
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
