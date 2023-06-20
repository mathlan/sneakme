<x-app-layout>
    <div class="create-main-box">
        <div class="add">
            <h2 class="create-title-form">Modifier le produit</h2>
            <form class="create-form" action="{{ route('users.update',$user) }}" method="post" enctype='multipart/form-data'>
                @csrf
                @method('PUT')
                <div class="w-full">
                    <div class="flex flex-col input-box">
                        <span>Nom du produit</span>
                        <input type="text" name="lastname" id="name" class="form-control" value="{{ $user->lastname}}">
                    </div>
                    <div class="flex flex-col input-box">
                        <span>Nom du produit</span>
                        <input type="text" name="firstname" id="name" class="form-control" value="{{ $user->firstname}}">
                    </div>
                    <div class="flex flex-col input-box">
                        <span>Nom du produit</span>
                        <input type="text" name="email" id="name" class="form-control" value="{{ $user->email}}">
                    </div>
                </div>
                <button class="create-button-add" type="submit">Modifier</button>
            </form>
        </div>
    </div>
</x-app-layout>
