@extends('layouts.app')

@section('content')

<section class="product-page">

    <!-- BREADCRUMB -->
    <nav class="breadcrumb">
        <a href="{{ url('/') }}">Home</a>
        <span>/</span>

        <a href="{{ url('/category/'.$product->category->slug) }}">
            {{ $product->category->name }}
        </a>
        <span>/</span>

        <span class="current">{{ $product->name }}</span>
    </nav>

    <div class="product-container">

        <!-- LEFT: IMAGES -->
        <div class="product-images">

            <div class="main-image">
                <img 
                    src="{{ asset('storage/'.$product->images->first()->image ?? 'images/default.png') }}"
                    alt="{{ $product->name }}"
                >
            </div>

        </div>

        <!-- RIGHT: DETAILS -->
        <div class="product-details">

            <h1 class="product-title">{{ $product->name }}</h1>

            <h2 class="product-price">
                ₦{{ number_format($product->price) }}
            </h2>

            <p class="product-description">
                {{ $product->description }}
            </p>

            <p class="stock">
                @if($product->stock > 0)
                    <span class="in-stock">In Stock ({{ $product->stock }})</span>
                @else
                    <span class="out-stock">Out of Stock</span>
                @endif
            </p>

            <!-- QUANTITY -->
            <div class="quantity-box">
                <button onclick="decreaseQty()">-</button>
                <input type="number" value="1" id="qty" min="1">
                <button onclick="increaseQty()">+</button>
            </div>

            <!-- ADD TO CART -->
            <button class="add-cart">
                Add to Cart
            </button>

        </div>

    </div>

</section>

<section class="section">
    <h2>Related Products</h2>

    <div class="products">
        @foreach($relatedProducts as $item)
            <a href="{{ url('/product/'.$item->slug) }}" class="card-link">
                <div class="card">
                    <img src="{{ asset('storage/'.$item->images->first()->image ?? 'images/default.png') }}">
                    <h3>{{ $item->name }}</h3>
                    <span class="price">₦{{ number_format($item->price) }}</span>
                </div>
            </a>
        @endforeach
    </div>
</section>


<section class="section">
    <h2>Latest Products</h2>

    <div class="products">
        @foreach($latestProducts as $item)
            <a href="{{ url('/product/'.$item->slug) }}" class="card-link">
                <div class="card">
                    <img src="{{ asset('storage/'.$item->images->first()->image ?? 'images/default.png') }}">
                    <h3>{{ $item->name }}</h3>
                    <span class="price">₦{{ number_format($item->price) }}</span>
                </div>
            </a>
        @endforeach
    </div>
</section>


<section class="section">
    


    <h3>Customer Reviews</h3>

    @forelse($reviews as $review)
    <div class="review">
        <strong>{{ $review->user->name }}</strong>
        <p>⭐ {{ $review->rating }}/5</p>
        <p>{{ $review->comment }}</p>
    </div>
    @empty
        <p>No reviews yet</p>
    @endforelse


    <hr>

<h3>Write a Review</h3>

@auth
<form method="POST" action="/reviews">
    @csrf

    <input type="hidden" name="product_id" value="{{ $product->id }}">

    <label>Rating</label>
    <select name="rating">
        <option value="5">★★★★★</option>
        <option value="4">★★★★</option>
        <option value="3">★★★</option>
        <option value="2">★★</option>
        <option value="1">★</option>
    </select>

    <textarea name="comment" placeholder="Write your review"></textarea>

    <button type="submit">Submit Review</button>
</form>
@else
<p><a href="/login">Login</a> to write a review</p>
@endauth

</section>

   





@if(isset($recentlyViewed) && count($recentlyViewed))
<section class="section">
    <h2>Recently Viewed</h2>

    <div class="products">
        @foreach($recentlyViewed as $item)
            <a href="{{ url('/product/'.$item->slug) }}" class="card-link">
                <div class="card">
                    <img src="{{ asset('storage/'.$item->images->first()->image ?? 'images/default.png') }}">
                    <h3>{{ $item->name }}</h3>
                    <span class="price">₦{{ number_format($item->price) }}</span>
                </div>
            </a>
        @endforeach
    </div>
</section>
@endif



<script>
function increaseQty() {
    let qty = document.getElementById('qty');
    qty.value = parseInt(qty.value) + 1;
}

function decreaseQty() {
    let qty = document.getElementById('qty');
    if (qty.value > 1) {
        qty.value = parseInt(qty.value) - 1;
    }
}
</script>

@endsection