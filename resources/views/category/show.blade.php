@extends('layouts.app')

@section('content')


<section class="section">

 <!-- BREADCRUMB -->
    <nav class="breadcrumb">
        <a href="{{ url('/') }}">Home</a>
        <span>/</span>

        <a href="{{ url('/category/'.$category->slug) }}">
            {{ $category->name }}
        </a>
    </nav>

    <!-- CATEGORY TITLE -->
    <h2>{{ $category->name }}</h2>

    <!-- PRODUCTS (same as homepage) -->
    <div class="products">
        @forelse ($products as $product)
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
        @empty
            <p>No products found in this category.</p>
        @endforelse
    </div>

</section>

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


@endsection