<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;

public function index()
{
    $orders = Order::where('user_id', Auth::id())
        ->with('items.product')
        ->latest()
        ->get();

    return view('orders.index', compact('orders'));
}
