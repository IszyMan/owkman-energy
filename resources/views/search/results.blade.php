@extends('layouts.app')

@section('content')

<section class="section">

    <!-- TITLE BLOCK -->
    <div class="search-header">
        <h2>Search Results for "{{ $query }}"</h2>

        @if($products->count())
            <p class="result-count">{{ $products->count() }} result(s) found</p>
        @endif
    </div>

    <!-- PRODUCTS GRID -->
    <div class="products">

        @forelse($products as $item)
            <a href="{{ url('/product/'.$item->slug) }}" class="card-link">
                <div class="card">

                    <!-- IMAGE SLIDER -->
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
        @empty
            <p>No products found.</p>
        @endforelse

    </div>

</section>

@endsection