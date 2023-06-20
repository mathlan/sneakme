<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::all();
        return view('order.admin',[
                'orders' => $orders
            ]
        );
    }

    public function show(Order $order)
    {
        return view('order.show', [
            'order' => $order
        ]);
    }

    public function edit(Order $order)
    {
       // $orders = Order::all();
        return view('order.edit',compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $validatedData = $request->validate([
            'status' => 'required|min:3|max:255',
        ]);

        //dd($validatedData);

        $order->update($validatedData);

        return redirect()->route('orders.index');
    }
}
