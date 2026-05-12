@extends('layouts.app')

@section('content')

<div class="cart-page">

    <h1 class="cart-title">Checkout</h1>

    @php
        $subtotal = 0;
    @endphp

    @forelse($cartItems as $item)

        @php
            $product = isset($item->product)
                ? $item->product
                : \App\Models\Product::find($item['product_id']);

            $quantity = $item->quantity ?? $item['quantity'];

            $total = $product->price * $quantity;

            $subtotal += $total;
        @endphp

        <div class="cart-card">

            <div class="cart-left">

                <img 
                    src="{{ $product->images->count() 
                        ? asset('storage/' . $product->images[0]->image)
                        : asset('images/default.png') }}"
                    class="cart-image"
                >

                <div>

                    <h3 class="cart-product-title">
                        {{ $product->name }}
                    </h3>

                    <p class="cart-price">
                        ₦{{ number_format($product->price) }}
                    </p>

                    <!-- QUANTITY CONTROLS -->
                    <div class="qty-controls">

                        <!-- DECREASE -->
                        <form method="POST" action="/cart/decrease">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <button type="submit">-</button>
                        </form>

                        <span>{{ $quantity }}</span>

                        <!-- INCREASE -->
                        <form method="POST" action="/cart/increase">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <button type="submit">+</button>
                        </form>

                    </div>

                    <!-- REMOVE -->
                    <form method="POST" action="/cart/remove" style="margin-top:10px;">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <button class="remove-btn">Remove</button>
                    </form>

                </div>

            </div>

            <div class="cart-total">
                ₦{{ number_format($total) }}
            </div>

        </div>

    @empty

        <div class="empty-cart">
            <p>Your cart is empty</p>
        </div>

    @endforelse


    @if(count($cartItems))

    <div class="cart-summary">

        <div class="summary-row">
            <span>Subtotal</span>
            <strong>₦{{ number_format($subtotal) }}</strong>
        </div>

        <div class="summary-row">
            <span>Shipping Fee</span>
            <strong>₦{{ number_format($shippingFee) }}</strong>
        </div>

        <hr>

        <div class="summary-row grand-total">
            <span>Total</span>
            <strong>₦{{ number_format($grandTotal) }}</strong>
        </div>

        <a href="#" class="checkout-btn">
            Pay Now
        </a>

    </div>

    @endif

</div>

@endsection