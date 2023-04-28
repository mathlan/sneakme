<x-app-layout>
        <section class="child-dash-menu">
            <h2>Réponse</h2>
            <div class="update">
                <div class="update-box">
                    <p>Modifier la réponse</p>
                    <a href="{{ route('answer.create') }}"><i class="fa-solid fa-plus"></i> Ajouter une réponse</a>
                </div>
                <div class="all-box">
                    <p>Nombre de produits :</p>
                    <?php
                    $all = count($answers);
                    echo '<p class="nbr-all">' . $all . '</p>';
                    ?>
                </div>
                <ul class="list-all">
                    @foreach ($answers as $answer)
                        <hr>
                        <li class="list-item-product" value="{{ $answer->id }}" {{ old('category_id') == $answer->id ? 'selected' : '' }}>
                            <a class="name-list-item" href="{{ route('answer.show', $answer) }}">{{ $answer->name }}</a>
                            <div class="product-crud">
                                <a href="{{ route('answer.show', $answer) }}">Voir</a>
                                <a class="btn-update" href="{{ route('answer.edit', $answer) }}"><span>Modifier <i class="fa-solid fa-wrench"></i></span></a>
                                <form action="{{ route('answer.destroy', $answer) }}" method="post" class="d-inline">
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
