<x-app-layout>
        <section class="child-dash-menu">
            <h2>Liste des mots Clés</h2>
            <div class="update">
                <div class="update-box">
                    <div class="all-box">
                        <p>Nombre de mots clés :</p>
                        <?php
                        $all = count($keywords);
                        echo '<p class="nbr-all">' . $all . '</p>';
                        ?>
                    </div>
                    <a href="{{ route('keyword.create') }}"><i class="fa-solid fa-plus"></i> Ajouter un mot clé</a>
                </div>
                <ul class="list-all">
                    @foreach ($keywords as $keyword)
                        <hr>
                        <li class="list-item-product" value="{{ $keyword->id }}" {{ old('category_id') == $keyword->id ? 'selected' : '' }}>
                            <a class="name-list-item" href="{{ route('keyword.show', $keyword) }}">{{ $keyword->name }}</a>
                            <div class="product-crud">
                                <a href="{{ route('keyword.show', $keyword) }}">Voir</a>
                                <a  class="btn-update" href="{{ route('keyword.edit', $keyword) }}"><span>Modifier <i class="fa-solid fa-wrench"></i></span></a>
                                <form action="{{ route('keyword.destroy', $keyword) }}" method="post" class="d-inline">
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
