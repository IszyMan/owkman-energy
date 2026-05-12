<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\MonnifyService;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | GET CART ITEMS
        |--------------------------------------------------------------------------
        */

        if (Auth::check()) {

            $cartItems = Cart::with('product.images')
                ->where('user_id', Auth::id())
                ->get();

        } else {

            $cartItems = session()->get('cart', []);
        }

        /*
        |--------------------------------------------------------------------------
        | CALCULATE SUBTOTAL
        |--------------------------------------------------------------------------
        */

        $subtotal = 0;

        foreach ($cartItems as $item) {

            // Logged in user
            if (Auth::check()) {

                $subtotal += $item->product->price * $item->quantity;

            }

            // Guest user
            else {

                $subtotal += $item['price'] * $item['quantity'];
            }
        }

        /*
        |--------------------------------------------------------------------------
        | SHIPPING FEE
        |--------------------------------------------------------------------------
        */

        $shippingFee = 5000;

        /*
        |--------------------------------------------------------------------------
        | GRAND TOTAL
        |--------------------------------------------------------------------------
        */

        $grandTotal = $subtotal + $shippingFee;

        return view('checkout', compact(
            'cartItems',
            'subtotal',
            'shippingFee',
            'grandTotal'
        ));
    }

    public function placeOrder(Request $request, MonnifyService $monnify)
    {
        $user = Auth::user();

        $cart = session()->get('cart');

        $total = 0;

        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        $order = Order::create([
            'user_id' => $user->id,
            'order_number' => 'ORD-'.time(),
            'total' => $total,
            'status' => 'pending',
            'payment_method' => 'monnify',
            'delivery_address' => $request->address,
            'phone' => $request->phone,
        ]);

        foreach ($cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price']
            ]);
        }

        // INIT MONNIFY PAYMENT
        $response = $monnify->initializePayment([
            "amount" => $total,
            "customerName" => $user->name,
            "customerEmail" => $user->email,
            "paymentReference" => $order->order_number,
            "paymentDescription" => "Owkman Energy Order",
            "currencyCode" => "NGN",
            "contractCode" => env('MONNIFY_CONTRACT'),
            "redirectUrl" => url('/payment/callback')
        ]);

        return redirect($response['responseBody']['checkoutUrl']);
    }
}