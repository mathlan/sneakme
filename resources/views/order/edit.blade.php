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
                                <p> ({{ $singleProduct-> quantity }})</p>
                            </div>
                        @endforeach
                    </div>
                    <strong>Satut de la commande :</strong>
                </div>
                <form class="create-form order-form" action="{{ route('orders.update',$order) }}" method="post" enctype='multipart/form-data'>
                    @csrf
                    @method('PUT')
                    <input id="getordervalue" type="hidden" value="{{ $order-> status }}">
                    <select name="status" id="status" class="form-control">
                        <option class="order-select-value" value="En cours">En cours</option>
                        <option class="order-select-value" value="En attente">En attente</option>
                        <option class="order-select-value" value="Expediée">Expediée</option>
                        <option class="order-select-value" value="Livrée">Livrée</option>
                    </select>
                    <button class="create-button-add" type="submit">Modifier</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
