<div class="dashboard-menu">
    <h1 class="dash-site-name">Sneack Me</h1>
    <h2 class="dash-main-title"><a href="/dashboard">Dashboard</a></h2>
    <p>Bonjour <?php echo Auth::user()->firstname; ?></p>
    <div class="menu-box first-menu-box">
        <h3 class="menu-box-title"><i class="fa-solid fa-inbox"></i>Produits</h3>
        <ul>
            <li><a href="{{ route('products.index') }}">Voir tous les produits</a></li>
            <li><a href="{{ route('products.create') }}">Ajouter un produit</a></li>
        </ul>
    </div>
    <div class="menu-box">
        <h3 class="menu-box-title"><i class="fa-solid fa-tags"></i>Catégories</h3>
        <ul>
            <li><a href="{{ route('categories.index') }}">Voir toutes les catégories</a></li>
            <li><a href="{{ route('categories.create') }}">Ajouter une catégorie</a></li>
        </ul>
    </div>
    <div class="menu-box">
        <h3 class="menu-box-title"><i class="fa-solid fa-puzzle-piece"></i>Mots Clés</h3>
        <ul>
            <li><a href="{{ route('keywords.index') }}">Voir tous les mots clés</a></li>
            <li><a href="{{ route('keywords.create') }}">Ajouter un mot clé</a></li>
        </ul>
    </div>
    <div class="menu-box">
        <h3 class="menu-box-title"><i class="fa-solid fa-comments"></i>Réponses</h3>
        <ul>
            <li><a href="{{ route('answers.index') }}">Voir toutes les réponses</a></li>
            <li><a href="{{ route('answers.create') }}">Ajouter une réponse</a></li>
        </ul>
    </div>
    <div class="menu-box">
        <h3 class="menu-box-title"><i class="fa-solid fa-user"></i>Utilisateurs</h3>
        <ul>
            <li><a href="{{ route('users.index') }}">Voir tous les utilisateurs</a></li>
            <li><a href="{{ route('orders.index') }}">Voir toutes les commandes</a></li>
        </ul>
    </div>
    <a style="color: red;" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Se déconnecter</a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</div>
