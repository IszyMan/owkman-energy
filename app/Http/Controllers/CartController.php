<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{

   public function add(Request $request)
    {
        $product = Product::findOrFail($request->product_id);

        // LOGGED IN USER
        if (Auth::check()) {

            $cart = Cart::where('user_id', Auth::id())
                ->where('product_id', $product->id)
                ->first();

            if ($cart) {
                $cart->increment('quantity');
            } else {
                Cart::create([
                    'user_id' => Auth::id(),
                    'product_id' => $product->id,
                    'quantity' => 1
                ]);
            }

            $count = Cart::where('user_id', Auth::id())->sum('quantity');

        } 
        // GUEST USER
        else {

            $cart = session()->get('cart', []);

            if (isset($cart[$product->id])) {
                $cart[$product->id]['quantity']++;
            } else {
                $cart[$product->id] = [
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'image' => $product->images->count()
                        ? $product->images[0]->image
                        : null,
                    'quantity' => 1
                ];
            }

            session()->put('cart', $cart);

            $count = collect($cart)->sum('quantity');
        }

        return response()->json([
            'success' => true,
            'cartCount' => $count,
            'product' => [
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->images->count()
                    ? asset('storage/' . $product->images[0]->image)
                    : asset('images/default.png')
            ]
        ]);
    }

    public function index()
    {
        if (Auth::check()) {

            $cartItems = Cart::with('product.images')
                ->where('user_id', Auth::id())
                ->get();

        } else {

            $cartItems = session()->get('cart', []);
        }

        return view('cart.index', compact('cartItems'));
    }

    public function increase(Request $request)
    {
        if (Auth::check()) {

            $cart = Cart::where('user_id', Auth::id())
                ->where('product_id', $request->product_id)
                ->first();

            if ($cart) {
                $cart->increment('quantity');
            }

        } else {

            $cart = session()->get('cart', []);

            if (isset($cart[$request->product_id])) {
                $cart[$request->product_id]['quantity']++;
            }

            session()->put('cart', $cart);
        }

        return back();
    }

    public function decrease(Request $request)
    {
        if (Auth::check()) {

            $cart = Cart::where('user_id', Auth::id())
                ->where('product_id', $request->product_id)
                ->first();

            if ($cart && $cart->quantity > 1) {
                $cart->decrement('quantity');
            }

        } else {

            $cart = session()->get('cart', []);

            if (isset($cart[$request->product_id])) {

                $cart[$request->product_id]['quantity']--;

                if ($cart[$request->product_id]['quantity'] <= 0) {
                    unset($cart[$request->product_id]);
                }
            }

            session()->put('cart', $cart);
        }

        return back();
    }

    public function remove(Request $request)
    {
        if (Auth::check()) {

            Cart::where('user_id', Auth::id())
                ->where('product_id', $request->product_id)
                ->delete();

        } else {

            $cart = session()->get('cart', []);

            unset($cart[$request->product_id]);

            session()->put('cart', $cart);
        }

        return back();
    }
        
}