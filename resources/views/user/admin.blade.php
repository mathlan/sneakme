<x-app-layout>
    <section class="child-dash-menu">
        <h2>Liste des utilisateurs</h2>
        <div class="update">
            <div class="update-box">
                <div class="all-box">
                    <p>Nombre des utilisateurs :</p>
                    <?php
                    $all = count($users);
                    echo '<p class="nbr-all">' . $all . '</p>';
                    ?>
                </div>
            </div>
            <ul class="list-all" id="paginated-list" data-current-page="1">
                @foreach ($users as $user)
                    <hr>
                    <li class="list-item-product" value="{{ $user-> id }}"><a class="name-list-item" href="{{ route('products.show', $user) }}">{{ $user-> lastname }} {{ $user-> firstname }}</a>
                        <p class="user-email">{{ $user-> email }}</p>
                        <div class="product-crud">
                            <a href="{{ route('products.show', $user) }}">Voir</a>
                            <a class="btn-update" href="{{ route('products.edit', $user) }}"><span>Modifier <i class="fa-solid fa-wrench"></i></span></a>
                            <form action="{{ route('products.destroy', $user) }}" method="post" class="d-inline">
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
