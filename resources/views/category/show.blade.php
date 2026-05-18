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
       
            <div class="card">
                <a href="{{ url('/product/'.$product->slug) }}" class="card-link">
                    <div class="img-box" data-product="{{ $product->id }}">

                        

                        <img 
                            class="slider-image"
                            src="{{ $product->images->count() 
                                ? asset('storage/' . $product->images[0]->image) 
                                : asset('images/default.png') }}"
                            data-index="0"
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
            
                <div class="card">
                    <a href="{{ url('/product/'.$item->slug) }}" class="card-link">
                        <div class="img-box" data-product="{{ $item->id }}">

                    

                        <img 
                            class="slider-image"
                            src="{{ $item->images->count() 
                                ? asset('storage/' . $item->images[0]->image) 
                                : asset('images/default.png') }}"
                            data-index="0"
                            loading="lazy"
                            alt="{{ $item->name }}"
                        />


                    </div>
                        <h3>{{ $item->name }}</h3>
                        <span class="price">₦{{ number_format($item->price) }}</span>
                    </a>
                     <button class="add-cart" onclick="addToCart({{ $item->id }})">
                        Add to Cart
                    </button>
                </div>
            
        @endforeach
    </div>
</section>


@endsection