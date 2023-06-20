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
}
