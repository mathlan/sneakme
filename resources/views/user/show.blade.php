<x-app-layout>
    <div class="create-main-box">
        <div class="add">
            <h2 class="create-title-form">{{ $user-> lastname }} {{ $user-> firstname }}</h2>
            <div class="create-form">
                <div class="flex flex-col">
                    <strong>Mail</strong>
                    <p> {{ $user-> email }} </p>
                </div>
                <div class="flex w-3/4 justify-between">
                    <div class="flex flex-col">
                        <strong>Créer le</strong>
                        <p> {{ $user->created_at }} </p>
                    </div>
                    <div class="flex flex-col">
                        <strong>Modifier le</strong>
                        <p> {{ $user->updated_at }} </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
