<x-app-layout>
    <div class="create-main-box">
        <div class="add">
            <h2 class="create-title-form">Commande de {{ $order->user->firstname }} {{ $order->user->lastname }} :</h2>
            <div class="create-form">
                <div class="flex flex-col">
                    <strong>Contenu de la commande :</strong>
                    <div>
                        @foreach ($order->orderItems as $singleProduct)
                            <div class="order-view">
                                <p> - {{ $singleProduct->product->name }}</p>
                                <img src="{{ asset( 'storage/product/' . $singleProduct->product->image) }}" >
                                <p> Qté : {{ $singleProduct-> quantity }}</p>
                            </div>
                        @endforeach
                    </div>
                    <strong>Satut de la commande :</strong>
                    <p>{{ $order-> status }}</p>
                </div>
                <div class="flex w-3/4 justify-between">
                    <div class="flex flex-col">
                        <strong>Créer le</strong>
                        <p> {{ $order->created_at }} </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
