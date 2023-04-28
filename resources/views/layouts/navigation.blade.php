<div class="dashboard-menu">
    <h1 class="dash-site-name">Sneack Me</h1>
    <h2 class="dash-main-title"><a href="/dashboard">Dashboard</a></h2>
    <div class="menu-box">
        <h3 class="menu-box-title"><i class="fa-solid fa-inbox"></i>Produits</h3>
        <ul>
            <li><a href="{{ route('product.index') }}">Voir tous les produits</a></li>
            <li><a href="{{ route('product.create') }}">Ajouter un produit</a></li>
        </ul>
    </div>
    <div class="menu-box">
        <h3 class="menu-box-title"><i class="fa-solid fa-tags"></i>Catergories</h3>
        <ul>
            <li><a href="{{ route('categories.index') }}">Voir toutes les catérgories</a></li>
            <li><a href="{{ route('categories.create') }}">Ajouter une catérgorie</a></li>
        </ul>
    </div>
    <div class="menu-box">
        <h3 class="menu-box-title"><i class="fa-solid fa-puzzle-piece"></i>Mots Clés</h3>
        <ul>
            <li><a href="{{ route('keyword.index') }}">Voir tous les mots clés</a></li>
            <li><a href="{{ route('keyword.create') }}">Ajouter un mot clé</a></li>
        </ul>
    </div>
    <div class="menu-box">
        <h3 class="menu-box-title"><i class="fa-solid fa-comments"></i>Réponses</h3>
        <ul>
            <li><a href="{{ route('answer.index') }}">Voir toutes les réponse</a></li>
            <li><a href="{{ route('answer.create') }}">Ajouter une réponse</a></li>
        </ul>
    </div>
</div>
