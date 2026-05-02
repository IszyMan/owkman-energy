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

            <!-- MAIN IMAGE -->
            <div class="main-image">
                <img id="mainProductImage"
                    src="{{ asset('storage/'.$product->images->first()->image ?? 'images/default.png') }}"
                    alt="{{ $product->name }}"
                >
            </div>

            <!-- THUMBNAILS -->
            <div class="thumbnail-list">

                @foreach($product->images as $img)
                    <img
                        src="{{ asset('storage/'.$img->image) }}"
                        class="thumbnail"
                        onclick="changeMainImage(this)"
                    >
                @endforeach

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
                    <div class="img-box" data-product="{{ $item->id }}">

                    <button class="prev" onclick="changeImage(this, -1)">‹</button>

                    <img 
                        class="slider-image"
                        src="{{ $item->images->count() 
                            ? asset('storage/' . $item->images[0]->image) 
                            : asset('images/default.png') }}"
                        data-index="0"
                    />

                    <button class="next" onclick="changeImage(this, 1)">›</button>

                    <!-- hidden images list -->
                    <div class="images-data" style="display:none;">
                        @foreach($item->images as $img)
                            <span>{{ $img->image }}</span>
                        @endforeach
                    </div>

                </div>
                    <h3>{{ $item->name }}</h3>
                    <span class="price">₦{{ number_format($item->price) }}</span>
                    <button>Add to Cart</button>
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
                    <div class="img-box" data-product="{{ $item->id }}">

                    <button class="prev" onclick="changeImage(this, -1)">‹</button>

                    <img 
                        class="slider-image"
                        src="{{ $item->images->count() 
                            ? asset('storage/' . $item->images[0]->image) 
                            : asset('images/default.png') }}"
                        data-index="0"
                    />

                    <button class="next" onclick="changeImage(this, 1)">›</button>

                    <!-- hidden images list -->
                    <div class="images-data" style="display:none;">
                        @foreach($item->images as $img)
                            <span>{{ $img->image }}</span>
                        @endforeach
                    </div>

                </div>
                    <h3>{{ $item->name }}</h3>
                    <span class="price">₦{{ number_format($item->price) }}</span>
                    <button>Add to Cart</button>
                </div>
            </a>
        @endforeach
    </div>
</section>

    
<section class="reviews-section">

    

    <div class="reviews-wrapper">

        <!-- REVIEW FORM -->
        <div class="review-form-wrapper">

            @if(session('success'))
                <div class="alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert-error">{{ session('error') }}</div>
            @endif

            <h3 class="form-title">Write a Review</h3>

            <form method="POST" action="/reviews" id="reviewForm">
                @csrf

                <input type="hidden" name="product_id" value="{{ $product->id }}">

                <label>Rating</label>
                <select name="rating" required>
                    <option value="">Select rating</option>
                    <option value="5">★★★★★</option>
                    <option value="4">★★★★</option>
                    <option value="3">★★★</option>
                    <option value="2">★★</option>
                    <option value="1">★</option>
                </select>

                <label>Comment</label>
                <textarea name="comment" placeholder="Write your review" required></textarea>

                <button type="submit">Submit Review</button>
            </form>

        </div>

        <!-- REVIEWS LIST -->
        <div class="reviews-list">
            <h3 class="section-title">Customer Reviews</h3>

            @forelse($reviews as $review)
                <div class="review-card">

                    <div class="review-header">
                        <strong>{{ $review->user->name }}</strong>
                        <span class="rating">⭐ {{ $review->rating }}/5</span>
                    </div>

                    <p class="review-text">
                        {{ $review->comment }}
                    </p>

                </div>
            @empty
                <p class="no-reviews">No reviews yet</p>
            @endforelse

        </div>

    </div>

</section>



@if(isset($recentlyViewed) && count($recentlyViewed))
<section class="section">
    <h2>Recently Viewed</h2>

    <div class="products">
        @foreach($recentlyViewed as $item)
            <a href="{{ url('/product/'.$item->slug) }}" class="card-link">
                <div class="card">
                    <div class="img-box" data-product="{{ $item->id }}">

                        <button class="prev" onclick="changeImage(this, -1)">‹</button>

                        <img 
                            class="slider-image"
                            src="{{ $item->images->count() 
                                ? asset('storage/' . $item->images[0]->image) 
                                : asset('images/default.png') }}"
                            data-index="0"
                        />

                        <button class="next" onclick="changeImage(this, 1)">›</button>

                        <!-- hidden images list -->
                        <div class="images-data" style="display:none;">
                            @foreach($item->images as $img)
                                <span>{{ $img->image }}</span>
                            @endforeach
                        </div>

                    </div>
                    <h3>{{ $item->name }}</h3>
                    <span class="price">₦{{ number_format($item->price) }}</span>
                    <button>Add to Cart</button>
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

<script>
    const isLoggedIn = @json(auth()->check());

    document.getElementById('reviewForm').addEventListener('submit', function(e) {
        if (!isLoggedIn) {
            e.preventDefault();
            alert('Please login first to write a review.');
            window.location.href = "/login";
        }
    });
</script>

<script>
function changeMainImage(el) {
    document.getElementById('mainProductImage').src = el.src;
}
</script>

@endsection