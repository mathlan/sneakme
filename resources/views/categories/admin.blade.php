<x-app-layout>
        <section class="child-dash-menu">
            <h2>Liste des categories</h2>
            <div class="update">
                <div class="update-box">
                    <div class="all-box">
                        <p>Nombre de categories :</p>
                        <?php
                        $all = count($categories);
                        echo '<p class="nbr-all">' . $all . '</p>';
                        ?>
                    </div>
                    <a href="{{ route('categories.create') }}"><i class="fa-solid fa-plus"></i> Ajouter une categorie</a>
                </div>
                <ul class="list-all">
                    @foreach ($categories as $category)
                        <hr>
                        <li class="list-item-product" value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            <span class="name-list-item">{{ $category->name }}</span>
                        <div class="product-crud">
                            <a class="btn-update" href="{{ route('categories.edit', $category) }}"><span>Modifier <i class="fa-solid fa-wrench"></i></span></a>
                            <form action="{{ route('categories.destroy', $category) }}" method="post" class="d-inline">
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
