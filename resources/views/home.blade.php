@extends('layouts.app')

@section('content')

<!-- FEATURED SLIDER 
<section class="featured-slider">
    <h2>🔥 Trending Products</h2>
    <div class="slider-box">

        @foreach($featured as $index => $item)
            <a href="{{ url('/product/'.$item->product->slug) }}">
                <img 
                    src="{{ $item->product->images->count() 
                        ? asset('storage/' .$item->product->images[0]->image) 
                        : asset('images/default.png') }}"
                    class="featured-slide {{ $index === 0 ? 'active' : '' }}"
                >
            </a>
        @endforeach

    </div>
</section>-->

<!-- CATEGORIES -->

<section class="section">
    <h2>Shop by Categories</h2>

    <div class="category-grid">
        @foreach($categories as $category)

            @php
                $icon = '📦'; // default icon

                if ($category->slug == 'cctv') $icon = '📷';
                elseif ($category->slug == 'solar-energy') $icon = '☀️';
                elseif ($category->slug == 'smart-watches') $icon = '⌚';
                elseif ($category->slug == 'smart-glasses') $icon = '🕶️';
                elseif ($category->slug == 'batteries') $icon = '🔋';
                elseif ($category->slug == 'accessories') $icon = '⚡';
            @endphp

            <a href="{{ url('/category/'.$category->slug) }}" class="cat"> 
                <span class="icon">{{ $icon }}</span>
                <span class="name">{{ $category->name }}</span>
            </a>

        @endforeach
    </div>
</section>


<!-- PRODUCTS -->
<section class="section">
    <h2>Latest Products</h2>

    <div class="products">
        @foreach ($products as $product)
        
            <div class="card">
                <a href="{{ url('/product/'.$product->slug) }}" class="card-link">
                    <div class="img-box" data-product="{{ $product->id }}">

                        

                        <img 
                            class="slider-image"
                            src="{{ $product->images->count() 
                                ? asset('storage/' .$product->images[0]->image) 
                                : asset('images/default.png') }}"
                            data-index="0"
                            loading="lazy"
                            alt="{{ $product->name }}"
                        />

                    </div>

                    <h3>{{ $product->name }}</h3>

                    <p>{{ Str::limit($product->description, 50) }}</p>

                    <span class="price">₦{{ number_format($product->price) }}</span>

                </a>
                
                <button class="add-cart" onclick="addToCart({{ $product->id }})">
                    Add to Cart
                </button>

            </div>
        
        @endforeach
    </div>
</section>


<!-- HERO -->
<section class="hero-banner">
    <div class="hero-content">
        <h1>Power Your Home with Solar & Smart Tech</h1>
        <p>CCTV • Solar Energy • Smart Devices</p>
        <button>Shop Now</button>
    </div>
</section>



<!-- TRENDING -->
<section class="section">
    <h2>🔥 Trending Products</h2>
     <div class="slider-box">

        @foreach($featured as $index => $item)
            <a href="{{ url('/product/'.$item->product->slug) }}">
                <img 
                    src="{{ $item->product->images->count() 
                        ? asset('storage/' .$item->product->images[0]->image) 
                        : asset('images/default.png') }}"
                    class="featured-slide {{ $index === 0 ? 'active' : '' }}"
                >
            </a>
        @endforeach

    </div>
</section>


<!-- PROMO BANNER -->
<section class="promo">
    <h2>⚡ 10% OFF Solar Kits This Week</h2>
</section>

<!-- TRUST SECTION -->
<section class="trust">
    <div>🚚 Fast Delivery</div>
    <div>🔒 Secure Payment</div>
    <div>🛠️ Installation Support</div>
    <div>📞 24/7 Support</div>
</section>






<script>
document.addEventListener("DOMContentLoaded", () => {

    const slides = document.querySelectorAll('.featured-slide');
    if (!slides.length) return;

    let index = 0;

    // ensure only first is active
    slides.forEach((s, i) => {
        s.classList.toggle('active', i === 0);
    });

    setInterval(() => {

        const current = slides[index];
        index = (index + 1) % slides.length;
        const next = slides[index];

        // switch without creating a "blank frame"
        current.classList.remove('active');
        next.classList.add('active');

    }, 3000);

});
</script>

@endsection