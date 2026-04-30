@extends('layouts.app')

@section('content')

<!-- HERO -->
<section class="hero">
    <h2>Affordable Solar & Smart Devices</h2>
    <p>Shop CCTV, Solar Lights, Smart Watches & More</p>
</section>

<!-- CATEGORIES -->
<section class="section">
    <h2>Categories</h2>

    <div class="categories">
        <div>Solar Lights</div>
        <div>CCTV</div>
        <div>Smart Watches</div>
        <div>Smart Glasses</div>
    </div>
</section>

<!-- PRODUCTS -->
<section class="section">
    <h2>Latest Products</h2>

    <div class="products">
        @foreach ($products as $product)
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
        @endforeach
    </div>
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

@endsection