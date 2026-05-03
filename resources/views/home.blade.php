@extends('layouts.app')

@section('content')

<!-- FEATURED SLIDER -->
<section class="featured-slider">
    <div class="slider-box">

        @foreach($featured as $index => $item)
            <a href="{{ url('/product/'.$item->product->slug) }}">
                <img 
                    src="{{ $item->product->images->count() 
                        ? asset('storage/'.$item->product->images[0]->image) 
                        : asset('images/default.png') }}"
                    class="featured-slide {{ $index === 0 ? 'active' : '' }}"
                >
            </a>
        @endforeach

    </div>
</section>

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
        <a href="{{ url('/product/'.$product->slug) }}" class="card-link">
            <div class="card">
                <div class="img-box" data-product="{{ $product->id }}">

                    <button class="prev" onclick="changeImage(this, -1)">‹</button>

                    <img 
                        class="slider-image"
                        src="{{ $product->images->count() 
                            ? asset('storage/' . $product->images[0]->image) 
                            : asset('images/default.png') }}"
                        data-index="0"
                    />

                    <button class="next" onclick="changeImage(this, 1)">›</button>

                    <!-- hidden images list -->
                    <div class="images-data" style="display:none;">
                        @foreach($product->images as $img)
                            <span>{{ $img->image }}</span>
                        @endforeach
                    </div>

                </div>

                <h3>{{ $product->name }}</h3>

                <p>{{ Str::limit($product->description, 50) }}</p>

                <span class="price">₦{{ number_format($product->price) }}</span>

                <button>Add to Cart</button>
            </div>
        </a>
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

    <div class="product-grid">
        @foreach($products->skip(6)->take(8) as $product)
            <div class="product-card">
                <img src="{{ asset('storage/'.$product->images->first()->image ?? 'images/default.png') }}">
                <h3>{{ $product->name }}</h3>
                <p>₦{{ number_format($product->price) }}</p>
            </div>
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
function changeImage(button, direction) {
    const slider = button.parentElement;
    const img = slider.querySelector('.slider-image');
    const imagesData = slider.querySelectorAll('.images-data span');

    let images = Array.from(imagesData).map(el => el.innerText);
    let index = parseInt(img.dataset.index);

    index += direction;

    if (index < 0) index = images.length - 1;
    if (index >= images.length) index = 0;

    img.src = '/storage/' + images[index];
    img.dataset.index = index;
}
</script>


<script>
let slides = document.querySelectorAll('.featured-slide');
let index = 0;

setInterval(() => {
    slides[index].classList.remove('active');

    index++;
    if (index >= slides.length) index = 0;

    slides[index].classList.add('active');
}, 3000);
</script>

@endsection