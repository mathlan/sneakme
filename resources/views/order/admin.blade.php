<x-app-layout>
    <section class="child-dash-menu">
        <h2>Liste des commandes</h2>
        <div class="update">
            <div class="update-box">
                <div class="all-box">
                    <p>Nombre des commandes :</p>
                    <?php
                    $all = count($orders);
                    echo '<p class="nbr-all">' . $all . '</p>';
                    ?>
                </div>
            </div>
            <ul class="list-all" id="paginated-list" data-current-page="1">
                @foreach ($orders as $order)
                    <hr>
                    <li class="list-item-product" value="{{ $order-> id }}"><a class="name-list-item" href="{{ route('users.show', $user) }}">{{ $user-> lastname }} {{ $user-> firstname }}</a>
                        <p class="user-email">{{ $user-> email }}</p>
                        <div class="product-crud">
                            <a href="{{ route('users.show', $user) }}">Voir</a>
                            <a class="btn-update" href="{{ route('users.edit', $user) }}"><span>Modifier <i class="fa-solid fa-wrench"></i></span></a>
                            <form action="{{ route('users.destroy', $user) }}" method="post" class="d-inline">
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
